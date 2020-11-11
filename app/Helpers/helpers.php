<?php

function getProductVariantsNames($variantAttributes)
	{
	    
	        foreach ($variantAttributes as $variantAttribute) {
	            $html[]=$variantAttribute->attribute->name.' - '.$variantAttribute->value;
	        }
	        
	    	return implode(",", $html);
	}