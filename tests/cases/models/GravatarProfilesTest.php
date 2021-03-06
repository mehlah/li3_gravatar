<?php
/**
 * li3_gravatar plugin for Lithium: the most rad php framework.
 *
 * @copyright     Copyright 2011, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
namespace li3_gravatar\tests\cases\models;

use li3_gravatar\tests\mocks\data\MockGravatarProfiles;
use li3_gravatar\models\GravatarProfiles;

class GravatarProfilesTest extends \lithium\test\Unit {

	public function testHash() {
		$expected = '5b9c2b225b5c4ff91ffe849209153ecc';
		$result = MockGravatarProfiles::hash('mail@example.org');
		$this->assertEqual($expected, $result);
	
		$result = MockGravatarProfiles::hash('MAIL@EXAMPLE.ORG');
		$this->assertEqual($expected, $result);
		
		$result = MockGravatarProfiles::hash(' mail@example.org ');
		$this->assertEqual($expected, $result);
	}
	
	public function testFetch() {
		$result = MockGravatarProfiles::fetch('invalid@example.org');
		$this->assertFalse($result);
	
		$result = MockGravatarProfiles::fetch('john@example.org');
		$this->assertTrue($result instanceof \lithium\data\Entity);
		$this->assertEqual('123', $result->id);
		$this->assertEqual('08aff750c4586c34375a0ebd987c1a7e', $result->hash);
	
		GravatarProfiles::config(array(
			'service' => array('socket' => 'lithium\tests\mocks\net\http\MockSocket')
		));
		$result = GravatarProfiles::fetch('invalid@example.org');
		$this->assertFalse($result);
	}

}

?>