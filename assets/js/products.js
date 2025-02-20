import { createApp, compile } from 'vue';

const app = createApp({
    data() {
        return {
            firstName: 'Najim',
        };
    },
    render() {
        // Compile the template and pass the context
        return compile('<h1>Hello {{ firstName }} Vue!</h1>')(this);
    }
});

app.mount('#app');
