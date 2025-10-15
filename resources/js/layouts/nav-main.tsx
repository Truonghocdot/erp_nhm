import { ChevronRight, LayoutDashboard, type LucideIcon, User } from 'lucide-react';

import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { IMenu } from '@/lib/types';
import { Link } from '@inertiajs/react';
import { Fragment, createElement } from 'react';

export const IconMap: Record<string, LucideIcon> = {
    LayoutDashboard: LayoutDashboard,
    User: User,
    // ... Thêm các icons khác
};

export default function NavMain({ menu }: { menu: IMenu[] }) {
    return (
        <SidebarGroup>
            <SidebarMenu>
                {menu.map((item, index) => (
                    <Fragment key={`${item.title}-${index}`}>
                        {item.can_show && (
                            <>
                                {item.is_menu ? (
                                    <>
                                        {/*Nếu có sub-menu*/}
                                        {item.items && Array.isArray(item.items) && item.items.length > 0 ? (
                                            <>
                                                <Collapsible key={item.title} asChild defaultOpen={item.active} className="group/collapsible">
                                                    <SidebarMenuItem>
                                                        <CollapsibleTrigger asChild>
                                                            <SidebarMenuButton tooltip={item.title} isActive={item.active}>
                                                                {item.icon && createElement(IconMap[item.icon])}
                                                                <span>{item.title}</span>
                                                                <ChevronRight className="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                                                            </SidebarMenuButton>
                                                        </CollapsibleTrigger>
                                                        <CollapsibleContent>
                                                            <SidebarMenuSub>
                                                                {item.items.map((subItem) => (
                                                                    <SidebarMenuSubItem key={subItem.title}>
                                                                        <SidebarMenuSubButton asChild isActive={subItem.active}>
                                                                            <Link href={subItem.url}>
                                                                                <span>{subItem.title}</span>
                                                                            </Link>
                                                                        </SidebarMenuSubButton>
                                                                    </SidebarMenuSubItem>
                                                                ))}
                                                            </SidebarMenuSub>
                                                        </CollapsibleContent>
                                                    </SidebarMenuItem>
                                                </Collapsible>
                                            </>
                                        ) : (
                                            <>
                                                {/*Trường hợp ko có sub-menu*/}
                                                <SidebarMenuItem>
                                                    <SidebarMenuButton asChild isActive={item.active}>
                                                        <Link href={item.url}>
                                                            {item.icon && createElement(IconMap[item.icon])}
                                                            <span>{item.title}</span>
                                                        </Link>
                                                    </SidebarMenuButton>
                                                </SidebarMenuItem>
                                            </>
                                        )}
                                    </>
                                ) : (
                                    <SidebarGroupLabel>{item.title}</SidebarGroupLabel>
                                )}
                            </>
                        )}
                    </Fragment>
                ))}
            </SidebarMenu>
        </SidebarGroup>
    );
}
