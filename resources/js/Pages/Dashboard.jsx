import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { ArrowDownIcon, ArrowUpIcon } from '@heroicons/react/20/solid'
import {CursorArrowRaysIcon, EnvelopeOpenIcon, HomeIcon, UsersIcon} from '@heroicons/react/24/outline'
const stats = [
    { id: 1, name: 'Total Customers', stat: '0', icon: UsersIcon},
    { id: 2, name: 'Total Categories', stat: '0', icon: EnvelopeOpenIcon},
    { id: 3, name: 'Total Authors', stat: '0', icon: CursorArrowRaysIcon},
    { id: 4, name: 'Total Books', stat: '0', icon: CursorArrowRaysIcon},
    { id: 5, name: 'Total Orders', stat: '0', icon: CursorArrowRaysIcon},
    { id: 6, name: 'Total Transactions', stat: '0', icon: CursorArrowRaysIcon},
]

function classNames(...classes) {
    return classes.filter(Boolean).join(' ')
}
const pages = [
    { name: 'Projects', href: '#', current: false },
    { name: 'Project Nero', href: '#', current: true },
]
export default function Dashboard({ auth }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />
            <nav className="flex border-b border-gray-200 bg-white" aria-label="Breadcrumb">
                <ol role="list" className="mx-auto flex w-full space-x-4 px-4 sm:px-6 lg:px-8">
                    <li className="flex">
                        <div className="flex items-center">
                            <a href="#" className="text-gray-400 hover:text-gray-500">
                                <HomeIcon className="h-5 w-5 flex-shrink-0" aria-hidden="true" />
                                <span className="sr-only">Home</span>
                            </a>
                        </div>
                    </li>
                    {pages.map((page) => (
                        <li key={page.name} className="flex">
                            <div className="flex items-center">
                                <svg
                                    className="h-full w-6 flex-shrink-0 text-gray-200"
                                    viewBox="0 0 24 44"
                                    preserveAspectRatio="none"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
                                </svg>
                                <a
                                    href={page.href}
                                    className="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                                    aria-current={page.current ? 'page' : undefined}
                                >
                                    {page.name}
                                </a>
                            </div>
                        </li>
                    ))}
                </ol>
            </nav>
            <div className="p-5">
                <dl className="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    {stats.map((item) => (
                        <div
                            key={item.id}
                            className="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6"
                        >
                            <dt>
                                <div className="absolute rounded-md bg-indigo-500 p-3">
                                    <item.icon className="h-6 w-6 text-white" aria-hidden="true" />
                                </div>
                                <p className="ml-16 truncate text-sm font-medium text-gray-500">{item.name}</p>
                            </dt>
                            <dd className="ml-16 flex items-baseline pb-6 sm:pb-7">
                                <p className="text-2xl font-semibold text-gray-900">{item.stat}</p>
                                <div className="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                                    <div className="text-sm">
                                        <a href="#" className="font-medium text-indigo-600 hover:text-indigo-500">
                                            View all<span className="sr-only"> {item.name} stats</span>
                                        </a>
                                    </div>
                                </div>
                            </dd>
                        </div>
                    ))}
                </dl>
            </div>
        </AuthenticatedLayout>
    );
}
