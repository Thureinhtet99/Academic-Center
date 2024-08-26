import { Pagination } from "@mui/material";

export default function PaginationComponent({ currentPage, itemsPerPage, handlePagination, list }) {

    return (
        <>
            <Pagination
                shape="rounded"
                variant="outlined"
                count={Math.ceil(list.length / itemsPerPage)}
                page={currentPage}
                onChange={handlePagination}
            />
        </>
    )
}