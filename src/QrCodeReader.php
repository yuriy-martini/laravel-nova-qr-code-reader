<?php

namespace Tsungsoft\QrCodeReader;

use Exception;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class QrCodeReader extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'qr-code-reader';

    /**
     * default value for this field
     */
    public $canSubmit = false;

    public $displayWidth = "auto";

    /**
     * @var Field
     */
    private $field;

    /**
     * Create a new field.
     *
     * @param Field $field
     */
    public function __construct(Field $field)
    {
        parent::__construct($field->name, $field->attribute, $field->resolveCallback);

        $this->field = $field;
    }

    public function canSubmit($canSubmit = true): self
    {
        $this->canSubmit = $canSubmit;

        return $this;
    }

    /**
     * @param string $displayWidth
     * @return $this
     */
    public function displayWidth(string $displayWidth): self
    {
        $this->displayWidth = $displayWidth;

        return $this;
    }

    /**
     * Set the validation rules for the field.
     *
     * @param callable|array|string $rules
     * @return $this
     */
    public function rules($rules)
    {
        $this->field->rules($rules);

        return $this;
    }

    /**
     * Get the validation rules for this field.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function getRules(NovaRequest $request)
    {
        return $this->field->getRules($request);
    }

    /**
     * Get the creation rules for this field.
     *
     * @param NovaRequest $request
     * @return array|string
     */
    public function getCreationRules(NovaRequest $request)
    {
        return $this->field->getCreationRules($request);
    }

    /**
     * Set the creation validation rules for the field.
     *
     * @param callable|array|string $rules
     * @return $this
     */
    public function creationRules($rules)
    {
        $this->field->creationRules($rules);

        return $this;
    }

    /**
     * Get the update rules for this field.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function getUpdateRules(NovaRequest $request)
    {
        return $this->field->getUpdateRules($request);
    }

    /**
     * Set the creation validation rules for the field.
     *
     * @param callable|array|string $rules
     * @return $this
     */
    public function updateRules($rules)
    {
        $this->field->updateRules($rules);

        return $this;
    }

    /**
     * @param $name
     * @return string
     * @throws Exception
     */
    function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        } elseif (isset($this->field->$name)) {
            return $this->field->$name;
        }

        throw new Exception("Undefined property \"$name\"");
    }

    public function __call($method, $arguments)
    {
        if (method_exists($this->field, $method)) {
            return call_user_func_array($this->field->$method, $arguments);
        }

        return parent::__call($method, $arguments);
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(
            [
                'field' => $this->field->jsonSerialize(),
                'canSubmit' => $this->canSubmit,
                'displayWidth' => $this->displayWidth,
            ],
            parent::jsonSerialize()
        );
    }
}
