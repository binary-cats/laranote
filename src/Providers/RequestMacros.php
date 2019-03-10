<?php

namespace BinaryCats\Laranote\Providers;

use BinaryCats\Laranote\Exceptions\NoteException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class RequestMacros extends ServiceProvider
{
    /**
     * List new methods for Blade compiler
     *
     * @var Array
     */
    protected $methods = [
        'decryptContextKey',
        'makeContext',
        'resolveContext',
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->methods as $directive) {
            $this->{$directive}();
        }
    }

    /**
     * Resolve subdomain from the Request
     *
     * @return void
     */
    public function decryptContextKey()
    {
        Request::macro('decryptContextKey', function ($string) {
            try {
                $context = decrypt($string);
            } catch (\Exception $e) {
                throw new NoteException($e->getMessage(), $e->getCode());
            }

            return $context;
        });
    }

    /**
     * Make a context out of an encrypted string
     *
     * @return void
     */
    public function makeContext()
    {
        Request::macro('makeContext', function ($string) {
            # decrypt
            $context = $this->decryptContextKey($string);
            # create new model
            $model = app()->make($context['model'])->newInstance([], true);
            # force fill
            return $model->forceFill([
                $model->getKeyName() => $context['id'],
            ]);
        });
    }

    /**
     * Resolve context from encrypted string
     *
     * @return void
     */
    public function resolveContext()
    {
        Request::macro('resolveContext', function ($string) {
            return $this->makeContext($string)->fresh();
        });
    }
}
