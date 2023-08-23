import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function List({ auth, pageTitle }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
        >
            <Head title={pageTitle} />

            <div className="py-12">
                <div className="mx-auto sm:px-6 lg:px-8 space-y-6">
                    {pageTitle}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
