<?php 

namespace App\Services;


class UserService
{
	/*
	* +
	*/ 
	public function Plus($a,$b)
	{
		return $a+$b;
	}

	/*
	*
	*/
	public function Rev(string $str)
	{
		return strrev($str);
	}
}