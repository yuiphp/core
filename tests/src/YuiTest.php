<?php

test('cannot dump')
	->expect(['var_dump', 'dump'])
	->not()
	->toBeUsed();

test('cannot use native dangerous functions')
	->expect(['sleep', 'eval', 'die'])
	->not()
	->toBeUsed();