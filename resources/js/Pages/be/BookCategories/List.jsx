import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/react';
import DataTable from "@/Components/DataTable.jsx";
import {PlusCircleIcon, XCircleIcon} from "@heroicons/react/20/solid/index.js";
import Swal from "sweetalert2";

export default function List({auth, pageTitle,pageDescription}) {
    const actionUrls = {
        createEditRouteName : 'dashboard.be.bookCategories.create',
        removeALlRouteName : 'dashboard.be.bookCategories.removeAll',
        removeRouteName : 'dashboard.be.bookCategories.remove',
        editRouteName : 'dashboard.be.bookCategories.edit'
    }
    const {
        get : destroyAll,
    } = useForm();
    const removeAll = (e, removeUrl) => {
        e.preventDefault();
        Swal.fire({
            title: 'Remove record, Are you sure?',
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes sure',
            denyButtonText: `Not right now`,
            allowOutsideClick : false,
        }).then((result) => {
            if (result.isConfirmed) {
                destroyAll(removeUrl, {
                    preserveScroll: true,
                    onSuccess: () => {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'All Record has been removed successfully',
                            showConfirmButton: false,
                            timer: 1500,
                            allowOutsideClick : false,
                        })
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Record is safe', '', 'info')
            }
        })
    };
    return (
        <AuthenticatedLayout
            user={auth.user}
        >
            <Head title={pageTitle}/>
            <div className="m-5 p-5 flow-root shadow sm:rounded-lg">
                <div className="sm:flex sm:items-center">
                    <div className="sm:flex-auto">
                        <h1 className="text-base font-semibold leading-6 text-gray-900">{pageTitle}</h1>
                        <p className="mt-2 text-sm text-gray-700">
                            {pageDescription}
                        </p>
                    </div>
                    <div className={'space-x-2 flex'}>
                        <div className="mt-4 sm:mt-0 sm:flex-none">
                            <Link
                                href={route(actionUrls.createEditRouteName)}
                                className="inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition ease-in-out duration-150"
                            >
                                <PlusCircleIcon className="-mr-0.5 h-5 w-5" aria-hidden="true" />
                                Add new
                            </Link>
                        </div>
                        <div className="mt-4 sm:mt-0 sm:flex-none">
                            <Link
                                href={'#'}
                                className="inline-flex items-center gap-x-1.5 rounded-md bg-red-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition ease-in-out duration-150"
                                onClick={(e) => {
                                    removeAll(e,route(actionUrls.removeALlRouteName))
                                }}
                            >
                                <XCircleIcon className="-mr-0.5 h-5 w-5" aria-hidden="true" />
                                Remove all
                            </Link>
                        </div>
                    </div>
                </div>
                <div className="mt-8 flow-root">
                    <DataTable
                        excludedColumns={['id']}
                        fetchUrl={route('fetch.bookCategories')}
                        columns={["id","name", "slug", "description", "parent_id", "is_active", "created_at", "updated_at"]}
                        actionUrls={actionUrls}
                    ></DataTable>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
