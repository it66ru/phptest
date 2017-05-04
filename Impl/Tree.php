<?php

class Tree implements iTree
{
    private $root;

    function __construct(iNode $root)
    {
        $this->root = $root;
    }

    function getRoot(): iNode
    {
        return $this->root;
    }

    function getNode(string $nodeName): iNode
    {
        return $this->getNodeByNameInNode($this->root, $nodeName);
    }

    private function getNodeByNameInNode(iNode $node, string $nodeName): iNode
    {
        if ($node->getName() != '') {
            if ($node->getName() == $nodeName) {
                return $node;
            }
            foreach ($node->getChildren() as &$childNode) {
                $node = $this->getNodeByNameInNode($childNode, $nodeName);
                if ($node->getName() != '') {
                    return $node;
                }
            }
        }
        return new Node('');
    }

    function appendNode(iNode $node, iNode $parent): iNode
    {
        $foundParentNode = $this->getNode($parent->getName());
        if ($foundParentNode->getName() != '') {
            $foundParentNode->addChild($node);
            return $node;
        } else {
            throw new ParentNotFoundException('Parent Not Found');
        }
    }

    function deleteNode(iNode $node)
    {
        $foundNode = $this->getNode($node->getName());
        if ($foundNode->getName() != '') {
            $foundNode->setName('');
        } else {
            throw new NodeNotFoundException('Node Not Found');
        }
    }

    function toJSON(): string
    {
        $data = ['root' => $this->getNodeData($this->root)];
        $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
        $json = $this->convertJsonToXson($json); // какой-то странный у вас json
        return $json;
    }

    private function getNodeData(iNode $node)
    {
        $data = [
            'name' => $node->getName(),
            'childs' => [],
        ];
        foreach ($node->getChildren() as $childNode) {
            if ($childNode->getName() != '') {
                $data['childs'][] = $this->getNodeData($childNode);
            }
        }
        return $data;
    }

    private function convertJsonToXson(string $json): string
    {
        $json = preg_replace('/"(.*)":/i', '\\1 :', $json);
        $json = str_replace('    ', "\t", $json);
        return $json;
    }
}