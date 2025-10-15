import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Field, FieldError, FieldGroup, FieldLabel } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { GalleryVerticalEnd } from 'lucide-react';
import { useFormLogin } from './hooks/use-form';

export default function Login() {
    const { form, handleSubmit } = useFormLogin();

    const { data, setData, errors } = form;

    return (
        <div className="flex min-h-svh flex-col items-center justify-center gap-6 bg-muted p-6 md:p-10">
            <div className="flex w-full max-w-sm flex-col gap-6">
                <a href="#" className="flex items-center gap-2 self-center font-medium">
                    <div className="flex size-6 items-center justify-center rounded-md bg-primary text-primary-foreground">
                        <GalleryVerticalEnd className="size-4" />
                    </div>
                    Acme Inc.
                </a>
                <div className={'flex flex-col gap-6'}>
                    <Card>
                        <CardHeader className="text-center">
                            <CardTitle className="text-xl">Chào mừng bạn quay trở lại</CardTitle>
                            <CardDescription>Đăng nhập tài khoản để tiếp tục</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <form onSubmit={handleSubmit}>
                                <FieldGroup>
                                    <Field>
                                        <FieldLabel htmlFor="email">Email</FieldLabel>
                                        <Input
                                            id="email"
                                            type="email"
                                            placeholder="email@example.com"
                                            required
                                            value={data.email}
                                            onChange={(e) => setData('email', e.target.value)}
                                        />
                                        {errors.email && <FieldError>{errors.email}</FieldError>}
                                    </Field>
                                    <Field>
                                        <FieldLabel htmlFor="password">Mật khẩu</FieldLabel>
                                        <Input
                                            id="password"
                                            type="password"
                                            required
                                            value={data.password}
                                            onChange={(e) => setData('password', e.target.value)}
                                        />
                                        {errors.password && <FieldError>{errors.password}</FieldError>}
                                    </Field>
                                    <Field>
                                        <Button type="submit">Đăng nhập</Button>
                                    </Field>
                                </FieldGroup>
                            </form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    );
}
