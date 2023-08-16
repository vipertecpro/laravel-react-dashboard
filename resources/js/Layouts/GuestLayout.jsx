import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';

export default function Guest({ children }) {
    return (
        <div className="flex min-h-full flex-1 flex-col justify-center py-12 sm:px-6 lg:px-8 h-screen">
            <div className="sm:mx-auto sm:w-full sm:max-w-md">
                <Link href="/">
                    <ApplicationLogo className="w-20 h-20 fill-current text-gray-500 mx-auto" />
                </Link>
                <h2 className="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                    Sign in to your account
                </h2>
            </div>

            <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
                {children}
            </div>
        </div>
    );
}
