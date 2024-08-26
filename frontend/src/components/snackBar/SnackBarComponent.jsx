import * as React from "react";
import Box from "@mui/material/Box";
import Snackbar from "@mui/material/Snackbar";
import { useState } from "react";

export default function SnackBarComponent({ snackBarOpen, snackBarMsg }) {
  const [state, setState] = useState({
    vertical: "bottom",
    horizontal: "right",
  });

  const { vertical, horizontal } = state;

  return (
    <Box sx={{ width: 500 }}>
      <Snackbar
        // autoHideDuration={4000}
        anchorOrigin={{ vertical, horizontal }}
        open={snackBarOpen}
        message={snackBarMsg}
        key={vertical + horizontal}
      />
    </Box>
  );
}
