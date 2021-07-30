<?php

namespace App\Data;

class SearchData
{
    /**
     * @var string
     */
    private $search = '';

    /**
     * @var string
     */
    private $roles = '';

    /**
     * @var int
     */
    private $page = 1;

    /**
     * Get the value of roles
     *
     * @return  string
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     *
     * @param  string  $roles
     *
     * @return  self
     */
    public function setRoles(?string $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get the value of search
     *
     * @return  string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * Get the value of pages
     *
     * @return  int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set the value of pages
     *
     * @param  int  $pages
     *
     * @return  self
     */
    public function setPage(?int $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Set the value of search
     *
     * @param  string  $search
     *
     * @return  self
     */
    public function setSearch(?string $search)
    {
        $this->search = $search;

        return $this;
    }
}
