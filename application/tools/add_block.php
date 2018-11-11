<?php

use Concrete\Core\Block\BlockType\BlockType;

$blockType = BlockType::getByHandle('dog_carousel');

if(!is_object($blockType))
{
    $blockType = BlockType::installBlockType('dog_carousel');
    echo 'installed';
}
else
{
    echo 'not installed, since it already was';
}
