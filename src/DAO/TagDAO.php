<?php

namespace Watson\DAO;

use Watson\Domain\Tag;

class TagDAO extends DAO
{
   /**
     * Returns tags associated with a link according to its id
     *
     * @param integer $id The link id.
     *
     * @return \Watson\Domain\Tag|false if no matching tag is found
     */
    public function find($id) {
        $sql = "
            SELECT tl_tags.tag_id, tl_tags.tag_name 
            FROM tl_tags
            INNER JOIN tl_tags_liens
                ON tl_tags_liens.tag_id = tl_tags.tag_id
            WHERE tl_tags_liens.lien_id = ?
        ";
        $result = $this->getDb()->fetchAll($sql, array($id));

        if ($result){
            // Convert query result to an array of domain objects
            $_tags = array();
            foreach ($result as $row) {
                $tagId         = $row['tag_id'];
                $_tags[$tagId] = $this->buildDomainObject($row);
            }

            return $_tags;
        }

        return false;
    } 

    /**
     * Returns a tag matching the supplied id.
     *
     * @param integer $id The tag id.
     *
     * @return \Watson\Domain\Tag|throws an exception if no matching tag is found.
     */
    public function findTagName($id) {
        $sql = "
            SELECT * 
            FROM tl_tags 
            WHERE tag_id = ?
        ";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row){
            return $this->buildDomainObject($row);
        }else{
            throw new \Exception("No tag matching id " . $id);
        }
    }

    /**
     * Saves a tag into the database.
     *
     * @param \Watson\Domain\Tag $tag The tag to save
     */
    public function save(Tag $tag) {
        $tagData = array(
            'tag_name'    => $tag->getTitle()
        );

        // Determine if insert tag in db
        $sql = "
            SELECT * 
            FROM tl_tags 
            WHERE tag_name = ?
        ";
        $row = $this->getDb()->fetchAssoc($sql, array($tag->getTitle()));

        if (!$row){
            $this->getDb()->insert('tl_tags', $tagData);
            // Get the id of the newly created tag and set it on the entity.
            $id = $this->getDb()->lastInsertId();
        }else{
            // Get the id of the tag
            $id = $row['tag_id'];
        }

        $tag->setId($id);
    }

    /**
     * Saves connection between link and tag into the database.
     *
     * @param integer $id The link id.
     * @param \Watson\Domain\Tag $tag The tag to save
     */
    public function saveConnection($id, Tag $tag) {
        $connectionData = array(
            'tag_id'    => $tag->getId(),
            'lien_id'   => $id
        );

        // Determine if insert connection in db
        $sql = "
            SELECT * 
            FROM tl_tags_liens 
            WHERE tag_id = ?
                AND lien_id = ?
        ";
        $row = $this->getDb()->fetchAssoc($sql, array($tag->getId(), $id));

        if (!$row){
            $this->getDb()->insert('tl_tags_liens', $connectionData);
        }
    }

    /**
     * Remove connection for a link into the database.
     *
     * @param integer $id The link id.
     */
    public function removeConnecion($id) {
        $this->getDb()->delete('tl_tags_liens', array('lien_id' => $id));
    }

    /**
     * Creates a Tag object based on a DB row.
     *
     * @param array $row The DB row containing Tag data.
     * @return \Watson\Domain\Tag
     */
    protected function buildDomainObject($row) {
        $user = new Tag();
        $user->setId($row['tag_id']);
        $user->setTitle($row['tag_name']);
        return $user;
    }
}
