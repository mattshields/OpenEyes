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

class CancelledBookingTest extends CDbTestCase
{
	public $model;
	
	public $fixtures = array(
		'users' => 'User',
		'bookings' => 'CancelledBooking',
		'reasons' => 'CancellationReason'
	);

	public function dataProvider_Search()
	{
		return array(
			array(array('element_operation_id' => 1), 1, array('booking1')),
			array(array('cancelled_date' => date('Y-m-d', strtotime('-30 days'))), 1, array('booking2')),
			array(array('user_id' => 1), 1, array('booking1')),
			array(array('user_id' => 2), 1, array('booking2')),
			array(array('theatre_id' => 3), 0, array()),
		);
	}
	
	public function setUp()
	{
		parent::setUp();
		$this->model = new CancelledBooking;
	}
	
	public function testModel()
	{
		$this->assertEquals('CancelledBooking', get_class(CancelledBooking::model()), 'Class name should match model.');
	}
	
	public function testAttributeLabels()
	{
		$expected = array(
			'id' => 'ID',
			'element_operation_id' => 'Element Operation',
			'date' => 'Date',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'theatre_id' => 'Theatre',
			'cancelled_date' => 'Cancelled Date',
			'user_id' => 'User',
			'cancelled_reason_id' => 'Cancelled Reason',
		);
		
		$this->assertEquals($expected, $this->model->attributeLabels());
	}

	/**
	 * @dataProvider dataProvider_Search
	 */
	public function testSearch_WithValidTerms_ReturnsExpectedResults($searchTerms, $numResults, $expectedKeys)
	{
		$booking = new CancelledBooking;
		$booking->setAttributes($searchTerms);
		$results = $booking->search();
		$data = $results->getData();

		$expectedResults = array();
		if (!empty($expectedKeys)) {
			foreach ($expectedKeys as $key) {
				$expectedResults[] = $this->bookings($key);
			}
		}

		$this->assertEquals($numResults, $results->getItemCount());
		$this->assertEquals($expectedResults, $data);
	}
}
