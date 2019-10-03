<?php

if (!function_exists('nominal')) {
	function nominal($angka){
		$nom = number_format($angka, 0, ',', '.');
		return "Rp. ".$nom;
	}
}

if (!function_exists('nominalToInt')) {
	function nominalToInt($str){
		$toInt = (int) str_replace(",", "", $str);
		return $toInt;
	}
}