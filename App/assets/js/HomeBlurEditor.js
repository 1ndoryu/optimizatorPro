// Prevenir carga duplicada

class HomeBlurEditor {
    constructor(blobs, initialSettings) {
        this.blobs = blobs;
        this.settings = initialSettings;
        // Definimos valores por defecto (coinciden con fallback de PHP)
        this.defaultSettings = {
            enabled: '1',
            opacity: '0.5',
            blur: '70',
            c1_top: '20',
            c1_left: '60',
            c2_top: '25',
            c2_left: '50'
        };
        this.container = null;
        this.isFusionBuilderActive = typeof isFusionBuilderActive === 'function' && isFusionBuilderActive();
        console.log('HomeBlurEditor constructor', {
            isFusionBuilderActive: this.isFusionBuilderActive,
            initialSettings: this.settings
        });
    }

    init() {
        console.log('HomeBlurEditor init start', {
            isFusionBuilderActive: this.isFusionBuilderActive,
            containerExists: !!document.getElementById('glory-blur-editor-container')
        });
        if (!this.isFusionBuilderActive || document.getElementById('glory-blur-editor-container')) {
            console.log('HomeBlurEditor no se activ f3: condiciones no cumplidas', {
                isFusionBuilderActive: this.isFusionBuilderActive,
                containerExists: !!document.getElementById('glory-blur-editor-container')
            });
            return;
        }
        this.crearUI();
        console.log('HomeBlurEditor UI creado');
        this.inyectarValores();
        console.log('HomeBlurEditor valores inyectados', this.settings);
        // Aplicar estilos iniciales según configuración guardada
        this.actualizarEstilosEnVivo();
        this.agregarEventListeners();
        console.log('HomeBlurEditor listeners agregados');
        console.log('HomeBlurEditor activado');
    }

    crearUI() {
        this.container = document.createElement('div');
        this.container.id = 'glory-blur-editor-container';
        this.container.innerHTML = `
            <button id="glory-blur-editor-toggle" class="glory-editor-button">Edit Blur Effect</button>
            <div id="glory-blur-editor-panel" class="glory-editor-panel hidden">
                <div class="glory-editor-field">
                    <label for="blur-enabled">Enable Effect</label>
                    <input type="checkbox" id="blur-enabled" data-setting="enabled" />
                </div>
                <div class="glory-editor-field">
                    <label for="blur-opacity">Opacity</label>
                    <input type="range" id="blur-opacity" min="0" max="1" step="0.05" data-setting="opacity" />
                    <span class="glory-editor-value"></span>
                </div>
                <div class="glory-editor-field">
                    <label for="blur-amount">Blur Amount</label>
                    <input type="range" id="blur-amount" min="50" max="250" step="5" data-setting="blur" />
                    <span class="glory-editor-value">px</span>
                </div>
                <div class="glory-editor-field">
                    <label>Circle 1 - Position (Top / Left)</label>
                    <input type="range" id="blur-c1-top" min="-50" max="150" step="1" data-setting="c1_top" />
                    <input type="range" id="blur-c1-left" min="-50" max="150" step="1" data-setting="c1_left" />
                </div>
                 <div class="glory-editor-field">
                    <label>Circle 2 - Position (Top / Left)</label>
                    <input type="range" id="blur-c2-top" min="-50" max="150" step="1" data-setting="c2_top" />
                    <input type="range" id="blur-c2-left" min="-50" max="150" step="1" data-setting="c2_left" />
                </div>
                <div class="button-container">
                    <button id="glory-blur-editor-save" class="glory-editor-button save">Save Changes</button>
                    <button id="glory-blur-editor-reset" class="glory-editor-button reset">Reset</button>
                </div>
                <p class="glory-editor-notice"></p>
                
            </div>
        `;
        document.body.appendChild(this.container);
        // Ocultamos el aviso inicialmente
        const noticeElement = this.container.querySelector('.glory-editor-notice');
        if (noticeElement) {
            noticeElement.style.display = 'none';
        }
    }

    inyectarValores() {
        const panel = document.getElementById('glory-blur-editor-panel');
        panel.querySelector('#blur-enabled').checked = this.settings.enabled === '1';
        this.actualizarInput('opacity', this.settings.opacity);
        this.actualizarInput('blur', this.settings.blur);
        this.actualizarInput('c1_top', this.settings.c1_top);
        this.actualizarInput('c1_left', this.settings.c1_left);
        this.actualizarInput('c2_top', this.settings.c2_top);
        this.actualizarInput('c2_left', this.settings.c2_left);
    }

    agregarEventListeners() {
        const toggleBtn = document.getElementById('glory-blur-editor-toggle');
        const panel = document.getElementById('glory-blur-editor-panel');

        // Toggle de panel y visibilidad del botón
        toggleBtn.addEventListener('click', () => {
            const estaOculto = panel.classList.toggle('hidden');
            toggleBtn.style.display = estaOculto ? 'block' : 'none';
        });

        // Cerrar panel al hacer click fuera
        document.addEventListener('click', (e) => {
            const clickDentroDelPanel = panel.contains(e.target);
            const clickEnToggle = e.target === toggleBtn;
            if (!clickDentroDelPanel && !clickEnToggle && !panel.classList.contains('hidden')) {
                panel.classList.add('hidden');
                toggleBtn.style.display = 'block';
            }
        });

        panel.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', () => this.actualizarEstilosEnVivo());
        });

        document.getElementById('glory-blur-editor-save').addEventListener('click', () => this.guardarAjustes());
        document.getElementById('glory-blur-editor-reset').addEventListener('click', () => this.reiniciarAjustes());
    }

    reiniciarAjustes() {
        // Restablece this.settings y actualiza UI/estilos
        this.settings = {...this.defaultSettings};
        this.inyectarValores();
        this.actualizarEstilosEnVivo();
    }

    actualizarInput(setting, value) {
        const input = document.querySelector(`[data-setting="${setting}"]`);
        if (input) {
            input.value = value;
            if (input.type === 'range' && input.nextElementSibling) {
                const suffix = input.nextElementSibling.textContent || '';
                input.nextElementSibling.textContent = `${value} ${suffix}`.trim();
            }
        }
    }

    actualizarEstilosEnVivo() {
        const panel = document.getElementById('glory-blur-editor-panel');
        const esActivo = panel.querySelector('#blur-enabled').checked;
        const opacidad = panel.querySelector('#blur-opacity').value;
        const desenfoque = panel.querySelector('#blur-amount').value;
        const c1Top = panel.querySelector('#blur-c1-top').value;
        const c1Left = panel.querySelector('#blur-c1-left').value;
        const c2Top = panel.querySelector('#blur-c2-top').value;
        const c2Left = panel.querySelector('#blur-c2-left').value;

        this.blobs.forEach((blob, index) => {
            blob.style.setProperty('display', esActivo ? 'block' : 'none', 'important');
            blob.style.setProperty('opacity', opacidad, 'important');
            blob.style.setProperty('filter', `blur(${desenfoque}px)`, 'important');
            if (index === 0) {
                blob.style.setProperty('top', `${c1Top}%`, 'important');
                blob.style.setProperty('left', `${c1Left}%`, 'important');
            } else {
                blob.style.setProperty('top', `${c2Top}%`, 'important');
                blob.style.setProperty('left', `${c2Left}%`, 'important');
            }
        });

        panel.querySelectorAll('input[type="range"]').forEach(input => {
            if (input.nextElementSibling) {
                const suffix = input.nextElementSibling.dataset.suffix || (input.id.includes('amount') ? 'px' : '');
                input.nextElementSibling.textContent = `${input.value} ${suffix}`.trim();
            }
        });
    }

    async guardarAjustes() {
        const panel = document.getElementById('glory-blur-editor-panel');
        const notice = panel.querySelector('.glory-editor-notice');
        notice.style.display = 'block';
        notice.textContent = 'Saving...';

        const datos = {
            subAccion: 'guardarHomeBlur',
            enabled: panel.querySelector('#blur-enabled').checked ? '1' : '0',
            opacity: panel.querySelector('#blur-opacity').value,
            blur: panel.querySelector('#blur-amount').value,
            c1_top: panel.querySelector('#blur-c1-top').value,
            c1_left: panel.querySelector('#blur-c1-left').value,
            c2_top: panel.querySelector('#blur-c2-top').value,
            c2_left: panel.querySelector('#blur-c2-left').value
        };

        const respuesta = await gloryAjax('gloryFormHandler', datos);

        if (respuesta.success) {
            notice.textContent = 'Saved successfully!';
            this.settings = { ...datos }; // Actualizamos cache local
        } else {
            notice.textContent = 'Error while saving: ' + (respuesta.data && respuesta.data.alert ? respuesta.data.alert : 'Unknown error.');
        }
        setTimeout(() => {
            notice.textContent = '';
            notice.style.display = 'none';
        }, 3000);
    }
}

// AUTO-INICIALIZACIÓN PARA DEPURACIÓN
// Fuerza la ejecución del editor aun cuando Fusion Builder no esté activo,
// para que puedas ver los logs y comprobar el flujo completo.
document.addEventListener('DOMContentLoaded', () => {
    try {
        // Only initialize inside Fusion Builder live editor
        if (typeof isFusionBuilderActive !== 'function' || !isFusionBuilderActive()) {
            console.log('HomeBlurEditor: Fusion Builder is not active, aborting initialization.');
            return;
        }

        console.log('Auto-init HomeBlurEditor...');
        const blobs = document.querySelectorAll('.blob');
        const defaultSettings = window.homeBlurSettings || {
            enabled: '1',
            opacity: 1,
            blur: 100,
            c1_top: 0,
            c1_left: 0,
            c2_top: 50,
            c2_left: 50
        };

        if (blobs.length === 0) {
            console.log('HomeBlurEditor auto-init: no .blob elements found');
            return;
        }

        const editor = new HomeBlurEditor(blobs, defaultSettings);
        editor.init();
    } catch (error) {
        console.error('HomeBlurEditor auto-init error', error);
    }
});
