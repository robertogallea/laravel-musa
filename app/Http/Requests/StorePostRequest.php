<?php

namespace App\Http\Requests;

use App\Rules\Uppercase;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $post_id = $this->route()->parameter('post')?->id;

        return [
            'title' => [
                'required',
                'string',
                'max:32',
                'unique:posts,title,' . $post_id,
                new Uppercase(),
                function (string $attribute, mixed $value, Closure $fail) { // il titolo non può contenere la parola post
                    if (strstr(strtolower($value),'post')) {
                        $fail('L\'attributo :attribute non può contenere la parola post');
                    }
                }
            ],
            'slug' => 'required|string|max:32|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:posts,slug,' . $post_id,
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Il :attribute è obbligatorio',
            'title.max' => 'La lunghezza massima del :attribute è :max caratteri',
            'body.required' => 'Il :attribute è obbligatorio',
            'slug.regex' => 'Il formato di :attribute non è valido (es. my-beautiful-post)'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'titolo del post',
            'body' => 'contenuto del post',
        ];
    }

    protected function prepareForValidation()
    {
        // effettuare operazioni prima che la validazione abbia luogo

        if (!$this->input('slug')) {
            $slug = Str::of($this->input('title'))
                ->slug()->toString();

            /*
             * merge() sovrascrive tutti i valori già presenti con la stessa chiave
             * mergeIfMissing() aggiungi i valori solo se non erano già presenti con la stessa chiave
             */
            $this->merge([
                'slug' => $slug
            ]);

        }

    }


}
