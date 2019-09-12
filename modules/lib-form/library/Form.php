<?php
/**
 * Form
 * @package lib-form
 * @version 0.0.1
 */

namespace LibForm\Library;

use LibValidator\Library\Validator;
use LibView\Library\View;

class Form
{

    private $errors = [];

    private $form;

    private $object;

    private $result;

    private $rules;

    public function __construct(string $name){
        $this->object = (object)[];
        $this->result = (object)[];

        $this->form = $name;
        
        $forms = \Mim::$app->config->libForm->forms;
        if(!isset($forms->$name))
            trigger_error('Form named `' . $name . '` not found');
        $this->rules = (object)$forms->$name;
    }

    public function addError(string $field, string $code, string $text=null): void{
        if(!$text){
            $locale = \Mim::$app->config->libValidator->errors->$code ?? '';
            if($locale)
                $text = lang($locale);
        }

        $error = (object)[
            'field' => $field,
            'code'  => $code,
            'text'  => $text
        ];

        $this->errors[$field] = $error;
    }

    public function csrfField(string $name='CSRFToken'): string{
        $token = sha1(base64_encode(random_bytes(25)));

        $cname = 'csrf-' . $token;

        \Mim::$app->cache->add($cname, ':)', ( 60 * 60 * 2 ));

        return '<input type="hidden" value="' . $token . '" name="' . $name . '">';
    }

    public function csrfTest(string $name='CSRFToken'): bool{
        $token = \Mim::$app->req->get($name);
        if(!$token)
            return false;

        $cname = 'csrf-' . $token;

        $cache = \Mim::$app->cache->get($cname);
        if(!$cache)
            return false;
        \Mim::$app->cache->remove($cname);
        return true;
    }

    public function field(string $name, $options=null): string{
        if(!isset($this->rules->$name))
            trigger_error('Field `' . $name . '` under form `' . $this->form . '` is not exists');

        $field_params = $this->rules->$name;
        $field_params->name = $name;
        $params = [
            'field'   => $field_params,
            'options' => $options,
            'value'   => $this->result->$name ?? $this->object->$name ?? null,
            'form'    => $this
        ];

        $view = 'form/field/' . $field_params->type;
        return View::render($view, $params);
    }

    public function getError(string $field): ?object{
        return $this->errors[$field] ?? null;
    }

    public function getErrors(): array{
        return $this->errors;
    }

    public function getName(): string{
        return $this->form;
    }

    public function getResult(): ?object{
        return $this->result;
    }

    public function hasError(): ?bool{
        return !!$this->errors;
    }

    public function setObject(object $object): void{
        $this->object = $object;
    }

    public function validate(object $object=null): ?object {
        if($object)
            $this->setObject($object);
        $to_validate = (object)\Mim::$app->req->get();
        list($result, $error) = Validator::validate($this->rules, $to_validate);

        $this->result = (object)$result;

        if($error){
            $this->errors = $error;
            return null;
        }

        return $this->result;
    }
}