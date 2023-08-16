import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/react';
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {useEffect} from "react";
import {XCircleIcon} from "@heroicons/react/20/solid/index.js";

export default function Form({auth, pageTitle,pageDescription, pageData, rolesList, formUrl}) {
    const {data, setData, patch, processing, errors, reset} = useForm({
        name: (pageData !== null) ?  pageData.name : '',
        email: (pageData !== null) ? pageData.email : '',
        password: '',
        password_confirmation: '',
        roles :(pageData !== null) ? (pageData.roles.length > 0) ? pageData.roles[0].name : '' : ''
    });

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation','roles');
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
                            <InputLabel htmlFor="role" value="Assign Role"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <select
                                    id="roles"
                                    name="roles"
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="roles"
                                    defaultValue={(pageData !== null) ? (pageData.roles.length > 0) ? pageData.roles[0].name : '': ''}
                                    onChange={(e) => setData('roles', e.target.value)}
                                >
                                    <option value={''}>Please select role</option>
                                    {rolesList.map((role,index) => {
                                        return (
                                            <>
                                                <option key={index} value={role.name}>{role.name}</option>
                                            </>
                                        );
                                    })}
                                </select>
                            </div>
                            <InputError message={errors.roles} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="name" value="Name"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="name"
                                    name="name"
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
                            <InputLabel htmlFor="email" value="Email"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="username"
                                    onChange={(e) => setData('email', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.email} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="password" value="Password"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="new-password"
                                    onChange={(e) => setData('password', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.password} className="mt-2"/>
                        </div>
                        <div>
                            <InputLabel htmlFor="password_confirmation" value="Confirm Password"
                                        className="block text-sm font-medium leading-6 text-gray-900"/>
                            <div className="mt-2">
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    value={data.password_confirmation}
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    autoComplete="new-password"
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.password_confirmation} className="mt-2"/>
                        </div>
                    </div>
                    <div className="flex items-center justify-end align-middle gap-2 pt-3 border-t">
                        <Link
                            href={route('dashboard.global.users.list')}
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
