'use client';

import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarRail } from '@/components/ui/sidebar';
import NavMain from '@/layouts/nav-main';
import NavUser from '@/layouts/nav-user';
import { IAuth, IMenu } from '@/lib/types';

export function AppSidebar({ menu, auth }: { menu: IMenu[]; auth: IAuth }) {
    return (
        <Sidebar collapsible="icon">
            <SidebarHeader>{/* Chuẩn bị cho các thành phần khác */}</SidebarHeader>
            <SidebarContent>
                <NavMain menu={menu} />
            </SidebarContent>
            <SidebarFooter>
                <NavUser auth={auth} />
            </SidebarFooter>
            <SidebarRail />
        </Sidebar>
    );
}
