import './styles/styles.scss';
import './scripts/scripts';
import Consent from './scripts/stores/Consent';

import Alpine from 'alpinejs'
window.Alpine = Alpine

import focus from '@alpinejs/focus'
import collapse from '@alpinejs/collapse'
import intersect from '@alpinejs/intersect'

Alpine.plugin(focus)
Alpine.plugin(collapse)
Alpine.plugin(intersect)

Alpine.store('consent', Consent)
Alpine.store('modalOpen', false)

Alpine.start()
