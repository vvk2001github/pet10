import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import { play } from './tetris/main';
window.play = play;
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
