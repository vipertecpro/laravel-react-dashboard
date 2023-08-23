import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';

export default function Guest({ children }) {
    return (
        <div className="flex min-h-full flex-1 flex-col justify-center py-12 sm:px-6 lg:px-8 h-screen">
            <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
                {children}
            </div>
        </div>
    );
}
