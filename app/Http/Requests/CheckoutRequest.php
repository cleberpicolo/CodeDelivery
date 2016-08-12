<?php

namespace CodeDelivery\Http\Requests;


use Illuminate\Http\Request as HttpRequest;

class CheckoutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param HttpRequest $request
     * @return array
     */
    public function rules(HttpRequest $request)
    {
        $rules = [
            'cupom_code' => 'exists:cupoms,code,used,0', //VERIFICA SE O CUPOM EXISTE E SE O NAO FOI USADO
        ];
        $this->buildRulesItems(0, $rules);
        $items = $request->get('items', []);
        $items = !is_array($items)? [] : $items;
        foreach ($items as $key => $val){
            $this->buildRulesItems($key, $rules);
        }

        return $rules;
    }

    public function buildRulesItems($key, array &$rules)
    {
        $rules["items.$key.product_id"] = 'required';
        $rules["items.$key.qtd"] = 'required';
    }
}
