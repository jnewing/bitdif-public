import { reactive, readonly } from 'vue';

const state = reactive({
    visible: false,
    title: '',
    message: '',
    resolve: null,
    reject: null,
});

const prompt = (options) => {
    return new Promise((resolve, reject) => {
        state.visible = true;
        state.title = options.title;
        state.message = options.message;
        state.resolve = resolve;
        state.reject = reject;
    });
};

const confirm = () => {
    if (state.resolve) {
        state.resolve(true);
        reset();
    }
};

const cancel = () => {
    if (state.reject) {
        state.reject(false);
        reset();
    }
};

const reset = () => {
    state.visible = false;
    state.title = '';
    state.message = '';
    state.resolve = null;
    state.reject = null;
};

export default {
    state,
    prompt,
    confirm,
    cancel,
};
