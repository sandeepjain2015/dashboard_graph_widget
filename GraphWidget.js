import React, { useState, useEffect, useCallback } from "react";
import {
  ResponsiveContainer,
  LineChart,
  Line,
  XAxis,
  YAxis,
  Tooltip,
  Legend,
  CartesianGrid,
} from "recharts";

const Dropdown = () => {
  const [selectedValue, setSelectedValue] = useState("7days");
  const localizedData = window.graph_widget_data;
  const [data, setData] = useState([]);

  const fetchData = useCallback(async () => {
    try {
      const response = await fetch(
        `${localizedData.site_url}/wp-json/graph-widget/v1/data?period=${selectedValue}`
      );
      if (!response.ok) {
        throw new Error(localizedData.error_fetching_data);
      }
      const data = await response.json();
      setData(data);
    } catch (error) {
      console.error(error);
    }
  }, [
    selectedValue,
    localizedData.site_url,
    localizedData.error_fetching_data,
  ]);

  useEffect(() => {
    fetchData(); // Call fetchData initially.
  }, [fetchData]);

  // Function to handle select change
  const handleSelectChange = (event) => {
    setSelectedValue(event.target.value);
  };

  return (
    <div className="border border-secondary m-5 p-5">
      <div className="row">
        <select
          className=" dropdown form-select form-select-lg mb-3"
          value={selectedValue}
          onChange={handleSelectChange}
        >
          <option value="7days">{localizedData.last_7_days}</option>
          <option value="15days">{localizedData.last_15_days}</option>
          <option value="1month">{localizedData.last_1_month}</option>
        </select>
      </div>
      <div className="row">
        {/* Recharts Line Chart */}
        <ResponsiveContainer width="98%" aspect={3}>
          <LineChart width={500} height={300} data={data}>
            <XAxis dataKey="name" />
            <YAxis />
            <CartesianGrid stroke="#ccc" />
            <Tooltip contentStyle={{ backgroundColor: "yellow" }} />
            <Legend />
            <Line dataKey="students" stroke="red" activeDot={{ r: 2 }} />
            <Line dataKey="fees" stroke="green" activeDot={{ r: 2 }} />
          </LineChart>
        </ResponsiveContainer>
      </div>
    </div>
  );
};

export default Dropdown;
