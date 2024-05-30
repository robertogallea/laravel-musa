import './bootstrap';

import Alpine from 'alpinejs';
import alertComp from '@utils/alert.js'

let appName = import.meta.env.VITE_APP_NAME;

console.log(appName)

alertComp.show();

window.Alpine = Alpine;

Alpine.start();

alert('hot module replacement')

import.meta.glob([
    '../images/**'
])
