<?php

namespace Calculator;

class Calculator implements CalculatorInterface
{
	/**
	 * total preserver the total, ok?
	 * @var integer
	 */
	protected $total = 0;

	/**
	 * Set Operations
	 * @param integer|float $operations
	 */
	public function set($operations)
	{

		$operations = $this->sanitize($operations);

		$arrDigits = $this->getDigits($operations);
		$arrOperations = $this->getOperations($operations);
		
		$total = array_shift($arrDigits);
		while (0 < count($arrDigits)) {
			$digit = array_shift($arrDigits);
			$operator = array_shift($arrOperations);
			$total = $this->makeOperation($total, $digit, $operator);
		}

		$this->total = $total;
	}

	/**
	 * calculate
	 * @return integer|float
	 */
	public function calculate()
	{
		return $this->total;
	}

	/**
	 * MakeOperations
	 * @param  integer|float $total
	 * @param  integer|float $intDigit
	 * @param  string $strOperator
	 * @return integer|float
	 */
	protected function makeOperation($total, $intDigit, $strOperator)
	{
		switch ($strOperator) {
			case '+':
					$total = $total + $intDigit;
				break;

			case '-':
					$total = $total - $intDigit;
				break;

			case '*':
					$total = $total * $intDigit;
				break;

			case '/':
					if ($this->preCheck($total, $intDigit)) {
						return null;
					}
					$total = $total / $intDigit;
				break;

			case '%':
					if ($this->preCheck($total, $intDigit)) {
						return null;
					}
					$total = $total % $intDigit;
				break;
			
			default:
				# code...
				break;
		}
		return $total;
	}

	/**
	 * preCheck
	 * 
	 * Check if we can perform the division
	 * 
	 * @param  integer|float $intTotal
	 * @param  integer|float $intValue
	 * @return boolean
	 */
	protected function preCheck($intTotal, $intValue)
	{
		if ($intValue == 0) {
			return true;
		}
		return false;
	}

	/**
	 * sanitize
	 * 
	 * I'm a machine.
	 * 
	 * @param  string $strOperations
	 * @return string
	 */
	protected function sanitize($strOperations)
	{
		$operations = str_replace([' ', 'MOD'], ['', '%'], $strOperations);
		return $operations;
	}

	/**
	 * getDigits
	 * 
	 * I want all the digits
	 * 
	 * @param  string $strOperations
	 * @return array
	 */
	protected function getDigits($strOperations)
	{
		preg_match_all("/[\d]/", $strOperations, $arrDigits);
		return $arrDigits[0];
	}

	/**
	 * getOperations
	 * 
	 * I want all the math operator
	 * 
	 * @param  string $strOperations
	 * @return array
	 */
	protected function getOperations($strOperations)
	{
		preg_match_all("/[\D]/", $strOperations, $arrOperations);
		return $arrOperations[0];
	}
}
