/**
 * Note Component
 *
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 *
 * https://github.com/mzabriskie/axios
 */

import Vue from 'vue';
import Laranotes from './Laranotes';

Vue.component('laranotes', Laranotes)
