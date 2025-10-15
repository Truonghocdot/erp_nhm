import { LoginForm } from '@/modules/User/utils/@type';
import { useForm } from '@inertiajs/react';
import {FormEvent} from 'react';




export const useFormLogin = () => {
    const form = useForm<LoginForm>({
        email: '',
        password: '',
    });

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        form.post('/login');
    };

    return {
        form,
        handleSubmit,
    };
};
