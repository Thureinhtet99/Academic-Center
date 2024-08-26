import { FormControl, InputLabel, MenuItem, Select } from "@mui/material";
import React from "react";

const SelectComponent = ({ list, selectedItem, handleChange, label }) => {
  return (
    <>
      <FormControl
        sx={{ m: 1, minWidth: 130 }}
        size="small"
        className="bg-white"
      >
        <InputLabel id={label}>{label}</InputLabel>
        <Select
          labelId={label}
          id={label}
          label={label}
          margin="dense"
          className="text-capitalize"
          value={selectedItem}
          onChange={handleChange}
        >
          <MenuItem className="text-primary" value="all">
            All
          </MenuItem>
          {list.map((item) => (
            <MenuItem className="text-capitalize" key={item.id} value={item.id}>
              {item.category_name}
            </MenuItem>
          ))}
        </Select>
      </FormControl>
    </>
  );
};

export default SelectComponent;
