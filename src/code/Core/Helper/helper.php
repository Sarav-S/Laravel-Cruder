<?php
/**
 * Returns authenticated admin user instance. If not logged in,
 * it'll throw AdminNotLoggedInException
 *
 * @return     mixed  \Code\Admin\Model\Admin instance | AdminNotLoggedInException
 */
function admin()
{
    if (!auth()->guard('admin')->check()) {
        throw \AdminNotLoggedInException;
    }

    return auth()->guard('admin')->user();
}

/**
 * Returns authenticated user instance. If not logged in,
 * it'll throw UserNotLoggedInException
 *
 * @return     mixed  \Code\User\Model\User instance | UserNotLoggedInException
 */
function user()
{
    if (!auth()->check()) {
        throw \UserNotLoggedInException;
    }

    return auth()->user();
}

/**
 * Sets the success flash message using session() helper
 *
 * @param   string
 */
function success($message)
{
    session()->flash('success', assign('success', $message));
}

/**
 * Sets the error flash message using session() helper
 *
 * @param   string
 */
function error($message)
{
    session()->flash('danger', assign('danger', $message));
}

/**
 * Sets the warning flash message using session() helper
 *
 * @param   string
 */
function warning($message)
{
    session()->flash('warning', assign('warning', $message));
}

/**
 * Clubs existing array values with new value and updates given session
 *
 * @param      string  $key      The key
 * @param      string  $message  The message
 *
 * @return     array
 */
function assign($key, $message)
{
    $session = session($key);
    $session[] = $message;

    return $session;
}

/**
 * Returns the notification messages.
 *
 * @return     string
 */
function notifications()
{
    return reduce(session('success'), 'alert alert-success').
            reduce(session('danger'), 'alert alert-danger').
            reduce(session('warning'), 'alert alert-warning');
}

/**
 * Reduces the session notification and renders them as html.
 *
 * @param      mixed  $session  The session
 * @param      string  $class    The class
 *
 * @return     string
 */
function reduce($session, $class)
{
    if (!count($session)) {
        return null;
    }

    $html = "<ul class='$class'>";
    foreach ($session as $item) {
        $html .= "<li>$item</li>";
    }
    $html .= "</ul>";

    return $html;
}

function renderField($record, $column)
{
    $type = isset($column['type']) ? $column['type'] : null;

    switch ($type) {
        case 'date':
            return $record->{$column['index']}->format(dateFormat());
            break;

        case 'file':
            return '<a href="'.asset($record->{$column['index']}).'" target="_blank"><img src="'.asset($record->{$column['index']}).'" width="50px"/></a>';
            break;

        default:
            return $record->{$column['index']};
    }
}

function dateFormat()
{
    return 'd-m-Y';
}

if (!function_exists('renderFormField')) {
    /**
     * Renders the field based on type. This function
     * is yet to completed.
     *
     * @param      Collection Object  $fields
     *
     * @return     string
     */
    function renderFormField($fields) : string
    {
        return collect($fields)->reduce(function ($initial, $value) {
            return $initial .= '<div class="form-group">'.
                            checkFieldAndAdd($value).
                        '</div>';
        }, '');
    }
}

if (!function_exists('checkFieldAndAdd')) {
    /**
     * Checks and then renders the field based on input type
     *
     * @param  Object $value
     *
     * @return string
     */
    function checkFieldAndAdd($value) : string
    {
        $html = '';
        $params = ['id' => $value->slug, 'class' => 'form-control'];

        if ($value->required) {
            $params['required'] = 'required';
        }

        switch ($value->input_type) {
            case "text":
                $html .= Form::label($value->label);
                $html .= Form::text($value->slug, setting($value->slug), $params);
                break;

            case "textarea":
                $html .= Form::label($value->label);
                $html .= Form::textarea($value->slug, setting($value->slug), $params);
                break;

            case "checkbox":
                $selected = (setting($value->slug)) ? true : false;
                $html .= Form::checkbox($value->slug, 1, $selected, ['id' => $value->slug]);
                $html .= '&nbsp;'.Form::label($value->slug, $value->label);
                break;

            case "file":
                $html .= Form::label($value->label);
                $html .= ($value->value) ? '<img src="'.asset('storage/'.$value->value).'" width="30px">' : '';
                $html .= Form::file($value->slug);
                $html .= '<p class="help-block">'.$value->help_text.'</p>';
                break;

            case "default":
                break;
        }

        return $html;
    }
}

if (!function_exists('setting')) {
    /**
     * Returns the setting value for the given slug
     *
     * @param   string  $item
     *
     * @return  string
     */
    function setting(string $item) :string
    {
        $settings = collect(getAllSettings())->filter(function ($value, $key) use ($item) {
            return $value->slug === $item;
        })->pluck('value')->first();

        return $settings ?? "";
    }
}

if (!function_exists('getAllSettings')) {
    /**
     * Gets all settings and saves in cache
     *
     * @return array  All settings.
     */
    function getAllSettings($flag = false) :array
    {
        return collect(getSettingsFromTable())->toArray();
    }
}

if (!function_exists('getSettingsFromTable')) {
    /**
     * Gets the settings from table.
     *
     * @return array  The settings from table.
     */
    function getSettingsFromTable() : array
    {
        if (empty(DB::select(DB::raw('SHOW tables like "settings"')))) {
            return [];
        }

        return DB::table('settings')->get()->toArray();
    }
}

if (!function_exists('urlsegment')) {
    /**
     * Returns the admin url segment
     *
     * @return  string
     */
    function urlsegment()
    {
        return request()->segment(config('admin.segment'));
    }
}

if (!function_exists('urlsegmentDecode')) {
    /**
     * Returns the admin url segment
     *
     * @return  string
     */
    function urlsegmentDecode()
    {
        return request()->segment(config('admin.segment'));
    }
}

if (!function_exists('renderDynamicFields')) {
    /**
     * Renders the fields on the fly
     *
     * @return  string
     */
    function renderDynamicFields($fields, $record = null)
    {
        return collect($fields)->reduce(function ($initial, $value) use ($record) {
            return $initial .= '<div class="form-group">'.
                            addDynamicFields($value, $record).
                        '</div>';
        }, '');
    }
}

if (!function_exists('addDynamicFields')) {
    function addDynamicFields($field, $record)
    {
        $html = '';
        $params = ['id' => $field['column'], 'class' => 'form-control'];

        if (isset($field['class'])) {
            $params['class'] = $field['class'].' form-control';
        }

        if ($field['required']) {
            $params['required'] = 'required';
        }

        if (isset($field['placeholder'])) {
            $params['placeholder'] = $field['placeholder'];
        }

        $value = $record->{$field['column']} ?? $field['value'];

        $params = (isset($field['attr'])) ? array_merge($params, $field['attr']) : $params;

        switch ($field['input']) {
            case "text":
                $html .= Form::label($field['label']);
                $html .= Form::text($field['column'], $value, $params);
                $html .= '<p class="help-block">'.$field['helpBlock'].'</p>';
                break;

            case "email":
                $html .= Form::label($field['label']);
                $html .= Form::input('email', $field['column'], $value, $params);
                $html .= '<p class="help-block">'.$field['helpBlock'].'</p>';
                break;

            case "password":
                $html .= Form::label($field['label']);
                $html .= Form::input('password', $field['column'], null, $params);
                $html .= '<p class="help-block">'.$field['helpBlock'].'</p>';
                break;

            case "textarea":
                $html .= Form::label($field['label']);
                $html .= Form::textarea($field['column'], $value, $params);
                $html .= '<p class="help-block">'.$field['helpBlock'].'</p>';
                break;

            case "checkbox":
                $selected = ($field['value']) ? true : false;
                $html .= Form::checkbox($field['column'], 1, $selected, ['id' => $field['column']]);
                $html .= '&nbsp;'.Form::label($field['column'], $field['label']);
                $html .= '<p class="help-block">'.$field['helpBlock'].'</p>';
                break;

            case "file":
                if (imageExists(asset('storage/'.$value))) {
                    $html .= '<a href="'.asset($value).'" target="_blank" class="block">
                                <img src="'.asset($value).'" alt="'.$value.'" width="50px">
                            </a>';
                }
                
                $html .= Form::label($field['label']);
                $html .= Form::file($field['column']);
                $html .= '<p class="help-block">'.$field['helpBlock'].'</p>';
                break;

            case "select":
                $html .= Form::label($field['label']);
                $html .= Form::select($field['column'], $field['option'], $value, $params);
                $html .= '<p class="help-block">'.$field['helpBlock'].'</p>';
                break;

            case "default":
                break;
        }

        return $html;
    }
}

function getOptions()
{
    return [
        '1' => 'Active',
        '0' => 'Inactive'
    ];
}

/**
 * Checks if image exists in given path
 *
 * @param      string  $url    The url
 *
 * @return     boolean
 */
function imageExists($url)
{
    return (@getimagesize($url)) ? true : false;
}
