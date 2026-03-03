<?php

	class CLASS_Numbertoword {
		
		const bAppendS = true; //Use this when the unit takes a "s" when multiplied
		const bDontAppendS = false; //Use this when the unit does'n't takes a "s" when multiplied
		
		const bSpecifyOne = true; //use this when we need to use the "one" word before the unit ie: un million
		const bDontSpecifyOne = false; //use this when we don't need to use the "one" word before the unit ie: mille (not "un mille")
		
		const bUseAndOne = true; //some tens might require a "and" modification ie : vingt-et-un
		const bDontUseAndOne = false; //some tens don't need a "and" modification ie: quatre-vingt-un
		
		private static $sCurrentLanguage; //we'll use this to store the language we are working with
		
		private static $a_Config = array (
			'DE' => array (					//German language contributed by Bernd Essl (bernd@ak-47.at)
			    'AndOneWord' => '',
			    'HundredsAndTensSeparator' => ' und ',
			    'Minus' => 'minus',
			    'Exceptions' => array (
			        '11'=> 'elf',
			        '12'=> 'zwölf',
			        '13'=> 'dreizehn',
			        '14'=> 'viezehn',
			        '15'=> 'fünfzehn',
			        '16'=> 'sechzehn',    
			        '17'=> 'siebzehn',    
			        '18'=> 'achtzehn',    
			        '19'=> 'neunzehn'
			    ),
			    'Units' => array (
			        'null',
			        'eins',
			        'zwei',
			        'drei',
			        'vier',
			        'fünf',
			        'sechs',
			        'sieben',
			        'acht',
			        'neun',
			    ),
			    'Tens' => array(
			        array ('',				self::bDontUseAndOne), //left empty so that the key is equal to the number
			        array ('zehn',			self::bDontUseAndOne),
			        array ('zwanzig',		self::bDontUseAndOne),
			        array ('dreisig',		self::bDontUseAndOne),
			        array ('vierzig',		self::bDontUseAndOne),
			        array ('fünfzig',		self::bDontUseAndOne),
			        array ('sechszig',		self::bDontUseAndOne),
			        array ('siebzig',		self::bDontUseAndOne),
			        array ('achtzig',		self::bDontUseAndOne),
			        array ('neunzig',		self::bDontUseAndOne)
			    ),
			    'Multipliers' => array (
			        array ('hundert',	self::bSpecifyOne,	self::bAppendS),
			        array ('tausend',	self::bSpecifyOne,	self::bAppendS),
			        array ('million',	self::bSpecifyOne,	self::bAppendS),
			        array ('billion',	self::bSpecifyOne,	self::bAppendS),
			        array ('trillion',	self::bSpecifyOne,	self::bAppendS)
			    )
			), 
			'EN' => array (
				'AndOneWord' => '',
				'HundredsAndTensSeparator' => ' and ',
				'Minus' => 'minus',
				'Exceptions' => array (
					'11'=> 'eleven',
					'12'=> 'twelve',
					'13'=> 'thirteen',
					'14'=> 'fourteen',
					'15'=> 'fifteen',
					'16'=> 'sixteen',	
					'17'=> 'seventeen',	
					'18'=> 'eighteen',	
					'19'=> 'nineteen'
				),
				'Units' => array (
					'zero',
					'one',
					'two',
					'three',
					'four',
					'five',
					'six',
					'seven',
					'eight',
					'nine',
				),
				'Tens' => array(
					array ('',			self::bDontUseAndOne), //left empty so that the key is equal to the number
					array ('ten',		self::bDontUseAndOne),
					array ('twenty',	self::bDontUseAndOne),
					array ('thirty',	self::bDontUseAndOne),
					array ('fourty',	self::bDontUseAndOne),
					array ('fifty',		self::bDontUseAndOne),
					array ('sixty',		self::bDontUseAndOne),
					array ('seventy',	self::bDontUseAndOne),
					array ('eigthy',	self::bDontUseAndOne),
					array ('ninety',	self::bDontUseAndOne)
				),
				'Multipliers' => array (
					array ('hundred',	self::bSpecifyOne,	self::bAppendS),
					array ('thousand',	self::bSpecifyOne,	self::bAppendS),
					array ('million',	self::bSpecifyOne,	self::bAppendS),
					array ('billion',	self::bSpecifyOne,	self::bAppendS),
					array ('trillion',	self::bSpecifyOne,	self::bAppendS)
				)
			),
			'FR' => array (
				'AndOneWord' => ' et un',
				'HundredsAndTensSeparator' => ' ',
				'Minus' => 'moins',
				'Exceptions' => array (
					'11'=> 'onze',
					'12'=> 'douze',
					'13'=> 'treize',
					'14'=> 'quatorze',
					'15'=> 'quinze',
					'16'=> 'seize',	
					'71'=> 'soixante et onze',
					'72'=> 'soixante-douze',
					'73'=> 'soixante-treize',
					'74'=> 'soixante-quatorze',
					'75'=> 'soixante-quinze',
					'76'=> 'soixante-seize',
					'80'=> 'quatre-vingts',
					'91'=> 'quatre-vingt-onze',
					'92'=> 'quatre-vingt-douze',
					'93'=> 'quatre-vingt-treize',
					'94'=> 'quatre-vingt-quatorze',
					'95'=> 'quatre-vingt-quinze',
					'96'=> 'quatre-vingt-seize'
				),
				'Units' => array (
					'zéro',
					'un',
					'deux',
					'trois',
					'quatre',
					'cinq',
					'six',
					'sept',
					'huit',
					'neuf'
				),
				'Tens' => array(
					array ('',					self::bDontUseAndOne), //left empty so that the key is equal to the number
					array ('dix',				self::bDontUseAndOne),
					array ('vingt',				self::bUseAndOne),
					array ('trente',			self::bUseAndOne),
					array ('quarante',			self::bUseAndOne),
					array ('cinquante',			self::bUseAndOne),
					array ('soixante',			self::bUseAndOne),
					array ('soixante-dix',		self::bDontUseAndOne),
					array ('quatre-vingt',		self::bDontUseAndOne),
					array ('quatre-vingt-dix',	self::bDontUseAndOne)
				),
				'Multipliers' => array (
					array ('cent',		self::bDontSpecifyOne,	self::bAppendS), //Name| if we must must use the word one ie ("cent" vs "un cent") |if we need to put a "s" when more then one and this completes the number
					array ('mille',		self::bDontSpecifyOne,	self::bDontAppendS),
					array ('million',	self::bSpecifyOne,		self::bAppendS),
					array ('milliard',	self::bSpecifyOne,		self::bAppendS),
					array ('billion',	self::bSpecifyOne,		self::bAppendS)
				)
			)
		);		
		
		private static function chunkToWord ($sChunk, $iMultiplier){
			$sReturn = '';
			
			if ($sChunk[0] == '0'){
				
			}
			else {
				if ($sChunk[0] == '1'){
					if (self::$a_Config[self::$sCurrentLanguage]['Multipliers'][0][1] == self::bDontSpecifyOne) {
						$sReturn .= self::$a_Config[self::$sCurrentLanguage]['Multipliers'][0][0];
					}
					else {
						$sReturn .= self::$a_Config[self::$sCurrentLanguage]['Units'][1].' '.self::$a_Config[self::$sCurrentLanguage]['Multipliers'][0][0];
					}
				}
				else {
					$sReturn .= self::$a_Config[self::$sCurrentLanguage]['Units'][$sChunk[0]].' '.self::$a_Config[self::$sCurrentLanguage]['Multipliers'][0][0];
						
					if (self::$a_Config[self::$sCurrentLanguage]['Multipliers'][0][2]){
						if (self::$sCurrentLanguage == 'FR'){
							if ($sChunk[1].$sChunk[2] == '00'){
								$sReturn .= 's';
							}
						}
						else {
							$sReturn .= 's';
						}
					}
				}
				if ($sChunk[1].$sChunk[2] != '00'){
					$sReturn .= self::$a_Config[self::$sCurrentLanguage]['HundredsAndTensSeparator'];
				}	
				else {
					$sReturn .= ' ';
				}
			}
			if (isset(self::$a_Config[self::$sCurrentLanguage]['Exceptions'][$sChunk[1].$sChunk[2]])){
				$sReturn .= self::$a_Config[self::$sCurrentLanguage]['Exceptions'][$sChunk[1].$sChunk[2]];
			}
			else {
				if ($sChunk[1] != '0'){
					$sReturn .= self::$a_Config[self::$sCurrentLanguage]['Tens'][$sChunk[1]][0];
				}
				if ($sChunk[2] != '0'){
					if ($sChunk[2] == '1' && self::$a_Config[self::$sCurrentLanguage]['Tens'][$sChunk[1]][1] == self::bUseAndOne){
						$sReturn .= self::$a_Config[self::$sCurrentLanguage]['AndOneWord'];
					}
					else {
						$sReturn .= ($sChunk[1] != '0' ?'-':'').self::$a_Config[self::$sCurrentLanguage]['Units'][$sChunk[2]];
					}
				}
			}
			
			if ($iMultiplier != 0){
				$sReturn .= ' '.self::$a_Config[self::$sCurrentLanguage]['Multipliers'][$iMultiplier][0];
				if ((integer) $sChunk > 1 && self::$a_Config[self::$sCurrentLanguage]['Multipliers'][$iMultiplier][1] == self::bAppendS){
					$sReturn .= 's'; 
				}
			}
			return $sReturn;
		}
		
		private static function toChunk ($iNumber){
			$sNumber = sprintf('%.0F',$iNumber);
			$iModulus = strlen($sNumber)%3;
			if ($iModulus != 0) {
				$sNumber = str_pad($sNumber,strlen($sNumber)+3-$iModulus,'0',STR_PAD_LEFT); //pad amount with zeroes
			}
			return array_reverse(array_reverse(str_split($sNumber,3)),true);
			
		}
		
		public static function convert ($iNumber, $sLanguage){
			$sLanguage = strtoupper($sLanguage);
			
			if (!isset(self::$a_Config[$sLanguage])){
				throw new Exception('Language undefined');
			}
			
			self::$sCurrentLanguage = $sLanguage;
			
			if (!is_integer($iNumber)){
				if (is_float($iNumber)){ //php threats very large numbers as float
					$iNumber = round($iNumber);
				}
				else {
					throw new Exception('iNumber should be an integer');
				}
			}
			if (-999999999999999 > $iNumber || $iNumber > 999999999999999){
				throw new Exception('iNumber is out of range');
			}
			
			$sReturn = '';
			
			if ($iNumber < 0) {
				$sReturn .= self::$a_Config[self::$sCurrentLanguage]['Minus'].' ';
				$iNumber = abs($iNumber);
			}
			
			if ($iNumber == 0){
				$sReturn .= self::$a_Config[self::$sCurrentLanguage]['Units'][0].' ';
			}
			else {
				$a_sChunks = self::toChunk($iNumber);
				
				foreach ($a_sChunks as $key => $value){
					if ($value != 000){
						$sReturn .= self::chunkToWord ($value, $key).' ';
					}
				}
			}				
			//converts first chars to Upper
			$sReturn [0] = strtoupper($sReturn [0]);
			
			//strips the last space
			$sReturn = substr($sReturn,0,strlen($sReturn) - 1);
			return $sReturn;
			
		}
	}
?>