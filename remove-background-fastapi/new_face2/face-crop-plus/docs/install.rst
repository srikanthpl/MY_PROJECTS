============
Installation
============

The packages requires at least *Python 3.10*. You may also want to set up *PyTorch* in advance from `here <https://pytorch.org/get-started/locally/>`_. 

To install the package via `pip <https://pypi.org/project/pip/>`_, simply run:

.. code-block:: bash

    pip install face-crop-plus

Or, to install it from source, run:

.. code-block:: bash

    git clone https://github.com/mantasu/face-crop-plus
    cd face-crop-plus && pip install .

.. note::

    By default, the required models will be automatically downloaded and saved under *Torch Hub* directory, which by default is ``~/.cache/torch/hub/checkpoints``. For more information and how to change it, see `Torch Hub documentation <https://pytorch.org/docs/stable/hub.html#where-are-my-downloaded-models-saved>`_.