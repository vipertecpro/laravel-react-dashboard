import React, { useEffect, useState } from "react"
import {ChevronLeftIcon, ChevronRightIcon} from "@heroicons/react/20/solid/index.js";
import {Link} from "@inertiajs/react";
import {v1 as uuidv1} from "uuid";

const OFFSET = 4

const Paginator = ({ pagination, pageChanged, totalItems }) => {
    const [pageNumbers, setPageNumbers] = useState([])
    useEffect(() => {
        const setPaginationPages = () => {
            let pages = []
            const { last_page, current_page, from, to } = pagination
            if (!to) return []
            let fromPage = current_page - OFFSET
            if (fromPage < 1) fromPage = 1
            let toPage = fromPage + OFFSET * 2
            if (toPage >= last_page) {
                toPage = last_page
            }
            for (let page = fromPage; page <= toPage; page++) {
                pages.push(page)
            }
            setPageNumbers(pages)
        }

        setPaginationPages()
    }, [pagination])

    return (
        <>
            <div className="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div className="flex flex-1 justify-between sm:hidden">
                    <a
                        href="#"
                        className="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        onClick={() => pageChanged(pagination.current_page - 1)}
                    >
                        Previous
                    </a>
                    <a
                        href="#"
                        className="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        onClick={() => pageChanged(pagination.current_page + 1)}
                    >
                        Next
                    </a>
                </div>
                <div className="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p className="text-sm text-gray-700">
                            Showing <span className="font-medium">{pagination.from}</span> to <span className="font-medium">{pagination.to}</span> of{' '}
                            <span className="font-medium">{pagination.total}</span> results
                        </p>
                    </div>
                    <div>
                        <nav className="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            <a
                                href="#"
                                className={"relative inline-flex items-center rounded-l-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 " + (pagination.current_page === 1 ? " pointer-events-none text-gray-800 bg-gray-200" : "")}
                                onClick={() => pageChanged(1)}
                            >
                                First
                            </a>
                            <a
                                href="#"
                                className={"relative inline-flex items-center px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0" + (pagination.current_page === 1 ? " pointer-events-none text-gray-800 bg-gray-200" : "")}
                                onClick={() => pageChanged(pagination.current_page - 1)}
                            >
                                <span className="sr-only">Previous</span>
                                <ChevronLeftIcon className="h-5 w-5" aria-hidden="true" />
                            </a>
                            {pageNumbers.map((pageNumber, index) => {
                                return (
                                    <a
                                        href={'#'}
                                        className={
                                            (pageNumber === pagination.current_page ? "relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" : "relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0")
                                        }
                                        key={uuidv1()}
                                        onClick={(e) => {
                                            e.preventDefault; pageChanged(pageNumber)
                                        }}
                                    >
                                        {pageNumber}
                                    </a>
                                )
                            })}
                            <a
                                href="#"
                                className={"relative inline-flex items-center  px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0" + (pagination.current_page === pagination.last_page ? " pointer-events-none text-gray-800 bg-gray-200" : "")}
                                onClick={() => pageChanged(pagination.current_page + 1)}
                            >
                                <span className="sr-only">Next</span>
                                <ChevronRightIcon className="h-5 w-5" aria-hidden="true" />
                            </a>
                            <a
                                href="#"
                                className={"relative ml-3 inline-flex items-center rounded-r-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50" + (pagination.current_page === pagination.last_page ? " pointer-events-none text-gray-800 bg-gray-200" : "")}
                                onClick={() => pageChanged(pagination.last_page)}
                            >
                                Last
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Paginator
