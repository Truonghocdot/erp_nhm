import { SidebarInset, SidebarProvider } from '@/components/ui/sidebar';
import { AppSidebar } from '@/layouts/app-sidebar';
import Header from '@/layouts/header';
import { usePage } from '@inertiajs/react';
import { FC, ReactNode } from 'react';

const MainLayout: FC<{
    children: ReactNode;
}> = ({ children }) => {
    const { breadcrumbs, menu, auth } = usePage().props;
    return (
        <SidebarProvider>
            <AppSidebar menu={menu} auth={auth}  />
            <SidebarInset>
                <Header breadcrumbs={breadcrumbs} />
                <main className="flex flex-1 flex-col gap-4 p-4 pt-0">{children}</main>
            </SidebarInset>
        </SidebarProvider>
    );
};
export default MainLayout;
