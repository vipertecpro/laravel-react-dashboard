import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/react';
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {useEffect} from "react";
import {XCircleIcon} from "@heroicons/react/20/solid/index.js";

export default function Form({auth, pageTitle, pageDescription, pageData, formUrl, book_categories}) {
    const {data, setData, post, processing, errors, reset} = useForm({
        name        : (pageData !== null) ? pageData.name : '',
        slug        : (pageData !== null) ? pageData.slug : '',
        description : (pageData !== null) ? pageData.description : '',
        is_active   : (pageData !== null) ? pageData.is_active : '1',
        parent_id   : (pageData !== null) ? pageData.parent_id : '0',
        icon_file_path   : '',
    });

    useEffect(() => {
        return () => {
            reset('name', 'slug','description','is_active','parent_id','icon_file_path');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(formUrl);
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
                <form onSubmit={submit} className="space-y-6 py-4" encType={`multipart/form-data`}>
                    <div className={`grid grid-cols-2 gap-4`}>
                        <div>
                            <InputLabel htmlFor="icon_file_path" value="Upload Icon"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    type={'file'}
                                    id={`icon_file_path`}
                                    name={`icon_file_path`}
                                    className={`block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6`}
                                    onChange={(e) => setData('icon_file_path', e.target.files[0])}
                                />
                                {(pageData !== null) ?
                                    <Link href={pageData.icon_file_path} target={'_blank'} className={'inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition ease-in-out duration-150'}>
                                        View Image
                                    </Link>
                                : ''}
                            </div>
                            <InputError message={errors.icon_file_path} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="parent_id" value="Parent Category"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <select
                                    id="parent_id"
                                    name="parent_id"
                                    defaultValue={pageData !== null ? pageData.parent_id : '0'}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="slug"
                                    onChange={(e) => setData('parent_id', e.target.value)}
                                >
                                    <option value={'0'}>Please select option</option>
                                    {book_categories.length > 0  ? book_categories.map((bc_data, key) => {
                                        return (<>
                                            <option key={key} value={bc_data.id}>{bc_data.name}</option>
                                        </>)
                                    }) : ''}
                                </select>
                            </div>
                            <InputError message={errors.is_active} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="is_active" value="Is Active ?"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <select
                                    id="is_active"
                                    name="is_active"
                                    defaultValue={pageData !== null ? pageData.is_active : '1'}
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
                                    defaultValue={pageData !== null ? pageData.description : ''}
                                    onChange={(e) => setData('description', e.target.value)}
                                ></textarea>
                            </div>
                            <InputError message={errors.description} className="mt-2"/>
                        </div>
                    </div>
                    <div className="flex items-center justify-end align-middle gap-2 pt-3 border-t">
                        <Link
                            href={route('dashboard.be.bookCategories.list')}
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
