import '../css/app.css';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import MainLayout from '@/layouts';
import React from 'react';
import { GlobModules, InertiaPageModule } from '@/lib/types';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';


createInertiaApp({
    title: (title) => title ? `${title} - ${appName}` : appName,
    resolve: (name) => {
        const pages = import.meta.glob<InertiaPageModule>('./modules/**/*.tsx', { eager: true }) as GlobModules;
        const page = pages[`./modules/${name}.tsx`];
        if (name === 'User/Login') {
            return page;
        }
        page.default.layout = (page => <MainLayout children={page} />)
        return page;
    },
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
}).then();
