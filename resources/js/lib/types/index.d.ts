import { _RBACPermission } from '@/lib/types/constant';
import { PageProps } from '@inertiajs/core';
import React from 'react';

type InertiaComponent = React.ComponentType & {
    layout?: (page: React.ReactNode) => React.ReactNode;
};
type InertiaPageModule = {
    default: InertiaComponent;
};
type GlobModules = Record<string, InertiaPageModule>;

export interface IUserAuth {
    id: number;
    email: string;
    name: string;
}

export interface IMenu {
    title: string;
    is_menu?: boolean;
    url?: string;
    icon?: string;
    active?: boolean;
    can_show?: boolean;
    items?: { title: string; url: string; active?: boolean; can_show?: boolean }[];
}

export interface IAuth {
    permission: {
        roles: { role_id: number; role_name: string }[];
        permissions: { [_RBACPermission]: string }[];
    } | null;
    user: IUserAuth | null;
}

export interface ISharedData {
    name: string;
    auth: IAuth;
    flash: {
        success: string | null;
        error: string | null;
        warning: string | null;
        info: string | null;
    };
    breadcrumbs: { label: string; url?: string }[];
    menu: IMenu[];
}

// ------------------------------------------------------------
// 1. Mở rộng PageProps của Inertia
declare module '@inertiajs/core' {
    // Tất cả usePage().props đều có ISharedData
    type PageProps = ISharedData;
}

// ------------------------------------------------------------
// 2. Định nghĩa kiểu cho Page Props tổng thể (bao gồm cả Page-Specific Props)
// Tận dụng cấu trúc Generic của PageProps<T>
export type InertiaPageProps<T extends Record<string, unknown> = Record<string, unknown>> = PageProps<T>;


