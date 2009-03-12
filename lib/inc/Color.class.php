<?php
/*
 * This work is hereby released into the Public Domain.
 * To view a copy of the public domain dedication,
 * visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
 * Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
 *
 */
 
/**
 * Create your colors
 *
 * @package Artichow
 */
class awColor {
	
	public $red;
	public $green;
	public $blue;
	public $alpha;

	/**
	 * Build your color
	 *
	 * @var int $red Red intensity (from 0 to 255)
	 * @var int $green Green intensity (from 0 to 255)
	 * @var int $blue Blue intensity (from 0 to 255)
	 * @var int $alpha Alpha channel (from 0 to 100)
	 */
	public function __construct($red, $green, $blue, $alpha = 0) {
	
		$this->red = (int)$red;
		$this->green = (int)$green;
		$this->blue = (int)$blue;
		$this->alpha = (int)round($alpha * 127 / 100);
		
	}
	
	/**
	 * Get RGB and alpha values of your color
	 *
	 * @return array
	 */
	public function getColor() {		
		return $this->rgba();
	}
	
	/**
	 * Change color brightness
	 *
	 * @param int $brightness Add this intensity to the color (betweeen -255 and +255)
	 */
	public function brightness($brightness) {
	
		$brightness = (int)$brightness;
	
		$this->red = min(255, max(0, $this->red + $brightness));
		$this->green = min(255, max(0, $this->green + $brightness));
		$this->blue = min(255, max(0, $this->blue + $brightness));
	
	}

	/**
	 * Get RGB and alpha values of your color
	 *
	 * @return array
	 */
	public function rgba() {
	
		return array($this->red, $this->green, $this->blue, $this->alpha);
	
	}
}
