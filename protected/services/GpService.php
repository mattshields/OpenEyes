<?php
/*
_____________________________________________________________________________
(C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
(C) OpenEyes Foundation, 2011
This file is part of OpenEyes.
OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
_____________________________________________________________________________
http://www.openeyes.org.uk   info@openeyes.org.uk
--
*/

class GpService
{
	/**
	 * Get all the GPs from PAS and either insert or update them in the OE db
	 *
	 * @param int $pasKey
	 */
	public function populateGps()
	{
		$contactType = ContactType::model()->find("name = 'GP'");

		if (!isset($contactType)) {
			exit("Unable to find GP contact type.\n");
		}

// For testing - getting all the GPs is very slow.
//		$results = PAS_Gp::model()->findAll(array('limit' => 100));
		$results = PAS_Gp::model()->findAll();

		if (!empty($results)) {
			foreach ($results as $pasGp) {
				$gp = Gp::model()->find('obj_prof = ?', array($pasGp->OBJ_PROF));

				if (isset($gp)) {
					// Update existing GP
					$contact = Contact::model()->findByPk($gp->contact_id);

					if (isset($contact)) {
						$this->populateContact($contact, $pasGp);

						$address = Address::model()->findByPk($contact->address_id);

						if (isset($address)) {
							$this->populateAddress($address, $pasGp);

							$this->populateGp($gp, $pasGp);
						} else {
							echo "No address for gp contact " . $contact->id . "\n";
						}
					} else {
						echo "Unable to update existing gp contact " . $pasGp->OBJ_PROF . "\n";
					}
				} else {
                                        $address = new Address;

                                        $this->populateAddress($address, $pasGp);
			
					$contact = new Contact;

					$contact->consultant = 0;
					$contact->address_id = $address->id;

					$this->populateContact($contact, $pasGp);

					$gp = new Gp;

					$gp->contact_id = $contact->id;

					$this->populateGp($gp, $pasGp);
				}
			}
		}
	}

	public function populateContact($contact, $pasGp)
	{
		$contact->title = $pasGp->TITLE;
		$contact->first_name = $pasGp->FN1 . ' ' . $pasGp->FN2;
		$contact->last_name = $pasGp->SN;
		$contact->primary_phone = $pasGp->TEL_1;
		$contact->save();
	}

	public function populateAddress($address, $pasGp)
	{
		$address->address1 = $pasGp->ADD_NAM . ' ' . $pasGp->ADD_NUM . ' ' . $pasGp->ADD_ST;
		$address->address2 = $pasGp->ADD_TWN . ' ' . $pasGp->ADD_DIS;
		$address->city = $pasGp->ADD_CTY;
		$address->postcode = $pasGp->PC;
		$address->country_id = 1;

		if (!$address->save()) {
			exit('failed to save address for ' . $pasGp->OBJ_PROF);
		}
	}

	public function populateGp($gp, $pasGp)
	{
		$gp->obj_prof = $pasGp->OBJ_PROF;
		$gp->nat_id = $pasGp->NAT_ID;
		$gp->save();
	}
}
