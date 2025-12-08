<?php

namespace Watson\Domain;

class Link 
{
    /**
     * Link id.
     *
     * @var integer
     */
    private $id;

    /**
     * Link title.
     *
     * @var string
     */
    private $title;

    /**
     * Link url.
     *
     * @var string
     */
    private $url;

    /**
     * Link desc.
     *
     * @var string
     */
    private $desc;

    /**
     * Associated user.
     *
     * @var \Watson\Domain\User
     */
    private $user;

    /**
     * Associated tag.
     *
     * @var array with Objects of \Watson\Domain\Tag
     */
    private $tags;

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

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser(User $user) {
        $this->user = $user;
    }

    public function getTags() {
        return $this->tags;
    }

    public function setTags($tags) {
        $this->tags = $tags;
    }

}
