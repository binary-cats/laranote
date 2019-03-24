/**
 * vue-api-query
 *
 * Define a base model
 *
 * @see  https://github.com/robsontenorio/vue-api-query
 * @package Monapix
 * @version 3.0.1
 * @author Binary Cats Inc.
 */

import { Model as BaseModel } from 'vue-api-query'

export default class Model extends BaseModel {

    /**
     * Define the extry point
     *
     * @return {[type]}
     */
    baseURL () {
        return '/api'
    }

    /**
     * implement a default request method
     *
     * @param  {[type]} config
     * @return {[type]}
     */
    request (config) {
        return this.$http.request(config)
    }
}
