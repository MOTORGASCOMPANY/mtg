import Alpine from "alpinejs";
import flatpickr from "flatpickr";
import Quill from "quill";
import * as FilePond from "filepond";
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import { createPopper } from "@popperjs/core";
import focus from "@alpinejs/focus";
import Chart from 'chart.js/auto';


Alpine.plugin(focus);

window.flatpickr = flatpickr;
window.FilePond = FilePond;
window.Quill = Quill;
window.Chart = Chart;
window.createPopper = createPopper;

// Register the plugin with FilePond
FilePond.registerPlugin(FilePondPluginImagePreview);
FilePond.registerPlugin(FilePondPluginFileValidateType);

window.Alpine = Alpine;

window.Alpine.start();

// Create a FilePond instance
