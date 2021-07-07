<?php namespace Kpolicar\BackendMenuPinnedPages\Models;

use Backend\Models\User;
use Model;

/**
 * PinnedPage Model
 */
class PinnedPage extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'backend_users_pinned_pages';

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [
        'label',
        'path',
        'icon',
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'label'
    ];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public $attributes = [
        'label' => 'Default label',
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'user' => User::class
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
