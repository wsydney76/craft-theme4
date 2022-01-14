import './styles/styles.scss';
import './scripts/scripts';
import Consent from './scripts/stores/Consent';

import Alpine from 'alpinejs'
window.Alpine = Alpine

import focus from '@alpinejs/focus'
import collapse from '@alpinejs/collapse'

Alpine.plugin(focus)
Alpine.plugin(collapse)

Alpine.store('consent', Consent)
Alpine.store('modalOpen', false)

Alpine.start()
