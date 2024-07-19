<?php

class Paginate
{
    public $current_page;
    public $items_per_page;
    public $items_total_count;

    public function __construct($page = 1, $items_per_page = 4, $items_total_count = 0)
    {
        $this->current_page = (int)$page;
        $this->items_per_page = (int)$items_per_page;
        $this->items_total_count = (int)$items_total_count;
    }

    //function to go to next page
    public function next()
    {
        return $this->current_page + 1;
    }

    //function to go to previous page
    public function previous()
    {
        return $this->current_page - 1;
    }

    public function total_pages()
    {
        //ceil() predefined function to round the number. ex:ceil(0.60)=>1 , ceil(0.40)=>1, ceil(5.1)=>1,ceil(5)=>5,ceil(-5.1)=>-5,ceil(-5.9)=>5
        return ceil($this->items_total_count / $this->items_per_page);
    }

    //find if we have previous page
    public function has_previous()
    {
        return $this->previous() >= 1 ? true : false;
    }

    //find if we have previous page
    public function has_next()
    {
        return $this->next() <= $this->total_pages() ? true : false;
    }

    //offset its to skip the previous rows. ex:offset=10 will skip first 10 rows and start after 10 
    public function offset()
    {
        return ($this->current_page - 1) * $this->items_per_page;
    }
}
