<?php

namespace Kordy\Ticketit\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'ticketit_categories';

    protected $fillable = ['name', 'color'];

    protected $appends = ['label'];

    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get related tickets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany('Kordy\Ticketit\Models\Ticket', 'category_id');
    }

    /**
     * Get related agents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents()
    {
        return $this->belongsToMany('\Kordy\Ticketit\Models\Agent', 'ticketit_categories_users', 'category_id', 'user_id');
    }

    /**
     * Get Sub categories of main category 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
      return $this->hasMany('Kordy\Ticketit\Models\Category', 'parent', 'id' );
    }

    /**
     * Get parent category
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent_category()
    {
        return $this->hasOne('Kordy\Ticketit\Models\Category', 'id', 'parent' );
    }

    /**
     * Return Label for select Box
     * @return string
     */
    public function getLabelAttribute()
    {
        if($this->parent !== null){
            return $this->parent_category->name.' - '.$this->name;
        }else{
            return $this->name;
        }

    }
    
    
}
