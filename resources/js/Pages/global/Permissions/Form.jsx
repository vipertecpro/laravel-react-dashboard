import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/react';
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {useEffect} from "react";
import {XCircleIcon} from "@heroicons/react/20/solid/index.js";

export default function Form({auth, pageTitle, pageDescription, pageData, formUrl}) {
    const {data, setData, patch, processing, errors, reset} = useForm({
        name        : (pageData !== null) ? pageData.name : '',
        slug        : (pageData !== null) ? pageData.slug : '',
        description : (pageData !== null) ? pageData.description : '',
        is_active   : (pageData !== null) ? pageData.is_active : '',
        guard_name  : (pageData !== null) ? pageData.guard_name : '',
    });

    useEffect(() => {
        return () => {
            reset('name', 'slug','description','is_active','guard_name');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        patch(formUrl);
    };
    return (
        <AuthenticatedLayout
            user={auth.user}
        >
            <Head title={pageTitle}/>
            <div className="m-5 p-5 flow-root shadow sm:rounded-lg">
                <div className="sm:flex sm:items-center border-b pb-3">
                    <div className="sm:flex-auto">
                        <h1 className="text-base font-semibold leading-6 text-gray-900">{pageTitle}</h1>
                        {pageDescription !== '' ? (<>
                            <p className="mt-2 text-sm text-gray-700">
                                {pageDescription}
                            </p>
                        </>) : '' }
                    </div>
                </div>
                <form onSubmit={submit} className="space-y-6">

                    <div className={`grid grid-cols-2 gap-4 py-4`}>
                        <div>
                            <InputLabel htmlFor="name" value="Name"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="name"
                                    name="name"
                                    type={'text'}
                                    placeholder={'Enter name'}
                                    value={data.name}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="name"
                                    isFocused={true}
                                    onChange={(e) => setData('name', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.name} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="slug" value="Slug"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="slug"
                                    name={'slug'}
                                    type={'text'}
                                    value={data.slug}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="slug"
                                    onChange={(e) => setData('slug', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.slug} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="is_active" value="Is Active ?"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <select
                                    id="is_active"
                                    name="is_active"
                                    defaultValue={pageData!== null ? pageData.is_active : ''}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="slug"
                                    onChange={(e) => setData('is_active', e.target.value)}
                                >
                                    <option value={''}>Please select option</option>
                                    <option value={'1'}>Yes</option>
                                    <option value={'0'}>no</option>
                                </select>
                            </div>
                            <InputError message={errors.is_active} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="guard_name" value="Guard Name"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="guard_name"
                                    type={'text'}
                                    name="guard_name"
                                    value={data.guard_name}
                                    placeholder={'Enter guard name'}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="slug"
                                    onChange={(e) => setData('guard_name', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.guard_name} className="mt-2"/>
                        </div>
                    </div>
                    <div className={'grid grid-cols-1 gap-4'}>
                        <div>
                            <InputLabel htmlFor="description" value="Description"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <textarea
                                    id="description"
                                    name="description"
                                    placeholder={'Enter description'}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="description"
                                    onChange={(e) => setData('description', e.target.value)}
                                >{pageData!== null ? pageData.description : ''}</textarea>
                            </div>
                            <InputError message={errors.description} className="mt-2"/>
                        </div>
                    </div>
                    <div className="flex items-center justify-end align-middle gap-2 pt-3 border-t">
                        <Link
                            href={route('dashboard.global.permissions.list')}
                            className="inline-flex items-center gap-x-1.5 rounded-md bg-gray-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition ease-in-out duration-150"
                        >
                            <XCircleIcon className="-mr-0.5 h-5 w-5" aria-hidden="true"/>
                            Cancel
                        </Link>
                        <PrimaryButton
                            className="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            disabled={processing}>
                            Submit
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
