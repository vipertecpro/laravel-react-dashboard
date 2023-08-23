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
        title       : (pageData !== null) ? pageData.title : '',
        ISBN_10     : (pageData !== null) ? pageData.ISBN_10 : '',
        ISBN_13     : (pageData !== null) ? pageData.ISBN_13 : '',
        author      : (pageData !== null) ? pageData.author : '',
    });

    useEffect(() => {
        return () => {
            reset('title', 'ISBN_10', 'ISBN_13', 'author');
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
                            <InputLabel htmlFor="title" value="Title"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="title"
                                    name="title"
                                    type={'text'}
                                    placeholder={'Enter title'}
                                    value={data.title}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="title"
                                    isFocused={true}
                                    onChange={(e) => setData('title', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.title} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="ISBN_10" value="ISBN 10"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="ISBN_10"
                                    name="ISBN_10"
                                    type={'text'}
                                    placeholder={'Enter ISBN 10'}
                                    value={data.ISBN_10}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="ISBN_10"
                                    isFocused={true}
                                    onChange={(e) => setData('ISBN_10', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.ISBN_10} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="ISBN_13" value="ISBN 13"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="ISBN_13"
                                    name="ISBN_13"
                                    type={'text'}
                                    placeholder={'Enter ISBN 13'}
                                    value={data.ISBN_13}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="ISBN_13"
                                    isFocused={true}
                                    onChange={(e) => setData('ISBN_13', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.ISBN_13} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="author" value="Author"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="author"
                                    name="author"
                                    type={'text'}
                                    placeholder={'Enter author name'}
                                    value={data.author}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="author"
                                    isFocused={true}
                                    onChange={(e) => setData('author', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.author} className="mt-2"/>
                        </div>
                    </div>
                    <div className="flex items-center justify-end align-middle gap-2 pt-3 border-t">
                        <Link
                            href={route('dashboard.be.books.list')}
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
