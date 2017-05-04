<?php

class Node implements iNode
{

    private $name;
    private $parent;
    private $childs = [];


    function __construct(string $name)
    {
        $this->setName($name);
    }

    function getName(): string
    {
        return $this->name;
    }

    function setName(string $name)
    {
        $this->name = $name;
    }

    function getChildren(): array
    {
        return $this->childs;
    }

    function addChild(iNode $child)
    {
        $this->childs[] = $child;
        $child->setParent($this);
    }

    function getParent(): iNode
    {
        return $this->parent;
    }

    function setParent(iNode $parent)
    {
        return $this->parent = $parent;
    }

}