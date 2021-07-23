<?php
return array(
    
	
	// set your 2checkout credential
    'enabled' => env('STRIPE_ENABLED', false),
    'public' => env('STRIPE_PUBLIC_KEY', ''),
    'private'    => env('STRIPE_PRIVATE_KEY', ''),

);