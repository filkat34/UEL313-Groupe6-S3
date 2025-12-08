<?php

namespace Watson\Domain;

class Tag 
{
    /**
     * Tag id.
     *
     * @var integer
     */
    private $id;

    /**
     * Tag title.
     *
     * @var string
     */
    private $title;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
}
