import Skeleton from "@mui/material/Skeleton";
import Box from "@mui/material/Box";

const CategoryBox = ({ progress, groupByCategories }) => {
  return (
    <>
      <div className="row">
        <h3 className="fw-bold mb-4">Categories</h3>
        <div
          className="overflow-auto px-3 shadow rounded"
          style={{ height: "200px" }}
        >
          {progress ? (
            <div className="text-center my-5">
              <div className="spinner-border" role="status">
                <span className="visually-hidden">Loading...</span>
              </div>
            </div>
          ) : (
            groupByCategories.map((category) => {
              return (
                <div
                  className="col-12 py-2 border-bottom"
                  key={category.categoryId}
                >
                  <div className="text-capitalize text-muted  d-flex justify-content-between align-items-center">
                    <span>
                      <i className="fa-solid fa-angles-right fa-xs me-2"></i>
                      {category.category_name}
                    </span>
                    <span className="mx-3">
                      ({category.courseCount > 0 ? category.courseCount : "0"})
                    </span>
                  </div>
                </div>
              );
            })
          )}
        </div>
      </div>
    </>
  );
};
export default CategoryBox;
