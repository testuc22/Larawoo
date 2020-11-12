<?php

function getProductVariantsNames($variantAttributes)
{    
    foreach ($variantAttributes as $variantAttribute) {
        $html[]=$variantAttribute->attribute->name.' - '.$variantAttribute->value;
    }    
	return implode(",", $html);
}

function getProductVariantImages($variant)
{
	return $variant->productVariantImages->pluck('image')->toArray();
}