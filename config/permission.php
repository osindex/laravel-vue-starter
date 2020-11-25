<?php return array (
  'models' => 
  array (
    'permission' => 'Spatie\\Permission\\Models\\Permission',
    'role' => 'Moell\\Mojito\\Models\\Role',
  ),
  'table_names' => 
  array (
    'roles' => 'roles',
    'permissions' => 'permissions',
    'model_has_permissions' => 'model_has_permissions',
    'model_has_roles' => 'model_has_roles',
    'role_has_permissions' => 'role_has_permissions',
  ),
  'column_names' => 
  array (
    'model_morph_key' => 'model_id',
  ),
  'display_permission_in_exception' => false,
  'display_role_in_exception' => false,
  'enable_wildcard_permission' => false,
  'cache' => 
  array (
    'expiration_time' => 
    DateInterval::__set_state(array(
       'y' => 0,
       'm' => 0,
       'd' => 0,
       'h' => 24,
       'i' => 0,
       's' => 0,
       'f' => 0.0,
       'weekday' => 0,
       'weekday_behavior' => 0,
       'first_last_day_of' => 0,
       'invert' => 0,
       'days' => 0,
       'special_type' => 0,
       'special_amount' => 0,
       'have_weekday_relative' => 0,
       'have_special_relative' => 0,
    )),
    'key' => 'spatie.permission.cache',
    'model_key' => 'name',
    'store' => 'default',
  ),
);