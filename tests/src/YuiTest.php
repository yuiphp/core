<?php

test('cannot dump')
	->expect(['var_dump', 'dump', 'ds'])
	->not()
	->toBeUsed();

test('cannot use native dangerous functions')
	->expect(['sleep', 'eval'])
	->not()
	->toBeUsed();